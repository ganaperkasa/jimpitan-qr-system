<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJimpitanRequest;
use App\Models\Jimpitan;
use App\Models\JimpitanLog;
use App\Models\Setting;
use App\Models\Warga;
use App\Support\Fmt;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class JimpitanController extends Controller
{
    /** Form catat jimpitan setelah QR dipindai (atau kode diketik manual). */
    public function create(Request $request): View|RedirectResponse
    {
        $kode = strtoupper(trim((string) $request->query('kode')));

        $warga = $kode !== '' ? Warga::where('kode_warga', $kode)->first() : null;

        if (! $warga) {
            return redirect()->route('scan')->with('galat', 'Kode warga tidak dikenal. Periksa kembali QR Code atau kode yang diketik.');
        }

        if (! $warga->aktif) {
            return redirect()->route('scan')->with('galat', $warga->nama.' sudah dinonaktifkan, jimpitan tidak dapat dicatat.');
        }

        return view('jimpitan.create', [
            'warga' => $warga,
            'setting' => Setting::current(),
            // Boleh lebih dari sekali per hari: tampilkan saja catatan hari ini sebagai peringatan.
            'hariIni' => $warga->jimpitans()->tercatat()->where('tanggal', today()->toDateString())->get(),
            'token' => (string) Str::uuid(),
        ]);
    }

    public function store(StoreJimpitanRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $warga = Warga::findOrFail($data['warga_id']);

        if (! $warga->aktif) {
            return redirect()->route('scan')->with('galat', $warga->nama.' sudah dinonaktifkan.');
        }

        try {
            $jimpitan = Jimpitan::firstOrCreate(
                ['token' => $data['token']],
                [
                    'warga_id' => $warga->id,
                    'user_id' => $request->user()->id,
                    'tanggal' => $data['tanggal'],
                    'nominal' => $data['nominal'],
                    'catatan' => $data['catatan'] ?? null,
                    'status' => 'tercatat',
                ],
            );
        } catch (UniqueConstraintViolationException) {
            // Klik ganda yang lolos bersamaan: data sudah tersimpan oleh permintaan pertama.
            $jimpitan = Jimpitan::where('token', $data['token'])->firstOrFail();
        }

        return redirect()->route('scan')->with('berhasil', [
            'nama' => $warga->nama,
            'rumah' => $warga->no_rumah,
            'nominal' => Fmt::rp($jimpitan->nominal),
        ]);
    }

    /** Riwayat transaksi dengan filter tanggal dan warga. */
    public function index(Request $request): View
    {
        $dari = $request->query('dari', today()->subDays(6)->toDateString());
        $sampai = $request->query('sampai', today()->toDateString());
        $cari = trim((string) $request->query('q'));

        $transaksi = Jimpitan::query()
            ->with(['warga', 'petugas'])
            ->whereBetween('tanggal', [$dari, $sampai])
            ->when($cari !== '', fn ($q) => $q->whereHas('warga', fn ($w) => $w->cari($cari)))
            ->latest('id')
            ->paginate(20)
            ->withQueryString();

        $total = Jimpitan::tercatat()
            ->whereBetween('tanggal', [$dari, $sampai])
            ->when($cari !== '', fn ($q) => $q->whereHas('warga', fn ($w) => $w->cari($cari)))
            ->sum('nominal');

        return view('jimpitan.index', compact('transaksi', 'dari', 'sampai', 'cari', 'total'));
    }

    /** Pembatalan hanya oleh admin, wajib beralasan, dan tercatat di log (tanpa hapus permanen). */
    public function batal(Request $request, Jimpitan $jimpitan): RedirectResponse
    {
        $data = $request->validate([
            'alasan' => ['required', 'string', 'min:5', 'max:255'],
        ], [
            'alasan.required' => 'Alasan pembatalan wajib diisi.',
            'alasan.min' => 'Alasan pembatalan minimal 5 karakter.',
        ]);

        if ($jimpitan->status !== 'tercatat') {
            return back()->with('galat', 'Transaksi ini sudah dibatalkan sebelumnya.');
        }

        DB::transaction(function () use ($jimpitan, $data, $request) {
            $jimpitan->update(['status' => 'dibatalkan']);

            JimpitanLog::create([
                'jimpitan_id' => $jimpitan->id,
                'user_id' => $request->user()->id,
                'aksi' => 'batal',
                'alasan' => $data['alasan'],
                'nominal_lama' => $jimpitan->nominal,
            ]);
        });

        return back()->with('sukses', 'Transaksi berhasil dibatalkan dan tercatat di log.');
    }
}

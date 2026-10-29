<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWargaRequest;
use App\Models\Warga;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class WargaController extends Controller
{
    public function index(Request $request): View
    {
        $status = in_array($request->query('status'), ['aktif', 'nonaktif'], true) ? $request->query('status') : null;

        $warga = Warga::query()
            ->cari($request->query('q'))
            ->when($status, fn ($q) => $q->where('status', $status))
            ->orderBy('no_rumah')
            ->orderBy('nama')
            ->paginate(15)
            ->withQueryString();

        return view('warga.index', [
            'warga' => $warga,
            'q' => (string) $request->query('q'),
            'status' => $status,
            'jumlahAktif' => Warga::aktif()->count(),
        ]);
    }

    public function create(): View
    {
        return view('warga.create');
    }

    public function store(StoreWargaRequest $request): RedirectResponse
    {
        $warga = DB::transaction(function () use ($request) {
            // Kode sementara agar unik, lalu diganti kode final berdasarkan ID.
            $warga = Warga::create($request->validated() + [
                'kode_warga' => 'TMP'.Str::upper(Str::random(12)),
                'status' => 'aktif',
            ]);
            $warga->update(['kode_warga' => Warga::kodeDariId($warga->id)]);

            return $warga;
        });

        return redirect()->route('warga.show', $warga)->with('sukses', 'Warga ditambahkan. QR Code siap dicetak.');
    }

    public function show(Warga $warga): View
    {
        return view('warga.show', ['warga' => $warga]);
    }

    public function edit(Warga $warga): View
    {
        return view('warga.edit', ['warga' => $warga]);
    }

    public function update(StoreWargaRequest $request, Warga $warga): RedirectResponse
    {
        $warga->update($request->validated());

        return redirect()->route('warga.show', $warga)->with('sukses', 'Data warga diperbarui.');
    }

    /** Nonaktifkan atau aktifkan kembali; data dan riwayat tetap tersimpan. */
    public function status(Warga $warga): RedirectResponse
    {
        $warga->update(['status' => $warga->aktif ? 'nonaktif' : 'aktif']);

        return back()->with('sukses', $warga->aktif ? 'Warga diaktifkan kembali.' : 'Warga dinonaktifkan.');
    }

    /** Halaman cetak kartu QR: satu warga (?id=) atau seluruh warga aktif. */
    public function cetak(Request $request): View
    {
        $daftar = Warga::aktif()
            ->when($request->query('id'), fn ($q, $id) => $q->whereKey($id))
            ->orderBy('no_rumah')
            ->orderBy('nama')
            ->get();

        return view('warga.cetak', ['daftar' => $daftar]);
    }
}

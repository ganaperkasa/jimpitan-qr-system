<?php

namespace App\Http\Controllers;

use App\Models\Jimpitan;
use App\Models\Warga;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LaporanController extends Controller
{
    public function index(Request $request): View
    {
        $mode = in_array($request->query('mode'), ['harian', 'bulanan', 'warga'], true) ? $request->query('mode') : 'harian';

        $tanggal = $this->parseTanggal($request->query('tanggal'));
        $bulan = $this->parseBulan($request->query('bulan'));
        $awal = $bulan->copy()->startOfMonth()->toDateString();
        $akhir = $bulan->copy()->endOfMonth()->toDateString();

        $data = ['mode' => $mode, 'tanggal' => $tanggal, 'bulan' => $bulan];

        if ($mode === 'harian') {
            $tgl = $tanggal->toDateString();
            $data['transaksi'] = Jimpitan::tercatat()
                ->with(['warga', 'petugas'])
                ->where('tanggal', $tgl)
                ->latest('id')
                ->get();
            $data['total'] = (int) $data['transaksi']->sum('nominal');
            // Warga aktif yang belum punya catatan pada tanggal tersebut.
            $data['belumTercatat'] = Warga::aktif()->whereDoesntHave('jimpitans', fn($q) => $q->tercatat()->where('tanggal', $tgl))->orderBy('no_rumah')->get();
        }

        if ($mode === 'bulanan') {
            $data['perHari'] = Jimpitan::tercatat()
                ->whereBetween('tanggal', [$awal, $akhir])
                ->selectRaw('tanggal, SUM(nominal) as total, COUNT(*) as jumlah')
                ->groupBy('tanggal')
                ->orderBy('tanggal')
                ->get();
            $data['total'] = (int) $data['perHari']->sum('total');
        }

        if ($mode === 'warga') {
            $data['perWarga'] = Warga::query()
                ->withSum(
                    [
                        'jimpitans as total' => function ($query) use ($awal, $akhir) {
                            $query->tercatat()->whereBetween('tanggal', [$awal, $akhir]);
                        },
                    ],
                    'nominal',
                )
                ->withCount([
                    'jimpitans as jumlah' => function ($query) use ($awal, $akhir) {
                        $query->tercatat()->whereBetween('tanggal', [$awal, $akhir]);
                    },
                ])
                ->orderByDesc('total')
                ->orderBy('no_rumah')
                ->get();

            $data['total'] = (int) $data['perWarga']->sum('total');
        }

        return view('laporan.index', $data);
    }

    private function parseTanggal(?string $nilai): Carbon
    {
        try {
            return $nilai ? Carbon::parse($nilai)->startOfDay() : today();
        } catch (\Throwable) {
            return today();
        }
    }

    private function parseBulan(?string $nilai): Carbon
    {
        try {
            return $nilai ? Carbon::createFromFormat('Y-m', $nilai)->startOfMonth() : today()->startOfMonth();
        } catch (\Throwable) {
            return today()->startOfMonth();
        }
    }
}

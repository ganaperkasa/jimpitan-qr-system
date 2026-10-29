<?php

namespace App\Http\Controllers;

use App\Models\Jimpitan;
use App\Models\Setting;
use App\Models\Warga;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $hariIni = today()->toDateString();

        $totalHariIni = Jimpitan::tercatat()->where('tanggal', $hariIni)->sum('nominal');
        $jumlahCatatan = Jimpitan::tercatat()->where('tanggal', $hariIni)->count();

        $wargaAktif = Warga::aktif()->count();
        // "Sudah" = warga aktif yang punya minimal satu catatan hari ini.
        $sudah = Warga::aktif()
            ->whereHas('jimpitans', fn ($q) => $q->tercatat()->where('tanggal', $hariIni))
            ->count();

        return view('dashboard.index', [
            'setting' => Setting::current(),
            'totalHariIni' => (int) $totalHariIni,
            'jumlahCatatan' => $jumlahCatatan,
            'wargaAktif' => $wargaAktif,
            'sudah' => $sudah,
            'belum' => max($wargaAktif - $sudah, 0),
            'persen' => $wargaAktif > 0 ? (int) round($sudah / $wargaAktif * 100) : 0,
            'terakhir' => Jimpitan::tercatat()->with(['warga', 'petugas'])->latest('id')->limit(5)->get(),
        ]);
    }
}

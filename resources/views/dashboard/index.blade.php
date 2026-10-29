@extends('layouts.app')

@use('App\Support\Fmt')

@section('title', 'Beranda')

@section('content')
    <header class="flex items-center justify-between">
        <div class="text-[26px] font-light tracking-tight">jimpi<span class="font-extrabold text-sun">t</span>an</div>
        <div class="flex size-[42px] items-center justify-center rounded-full bg-linear-to-br from-lilac to-blush text-sm font-extrabold text-ink-950" title="{{ auth()->user()->name }}">
            {{ auth()->user()->inisial }}
        </div>
    </header>

    <section>
        <div class="text-[13px] text-muted">{{ Fmt::tanggal(today(), 'l, j F Y') }}</div>
        <h1 class="mb-2.5 mt-1 text-2xl font-bold leading-tight">Halo, {{ auth()->user()->name }}</h1>
        <span class="chip bg-mint/15 !text-xs text-mint">{{ $setting->nama_rt }} / {{ $setting->nama_rw }} · {{ auth()->user()->isAdmin() ? 'Admin' : 'Petugas' }}</span>
    </section>

    <section class="relative overflow-hidden rounded-[26px] bg-linear-to-br from-sun to-coral p-5 text-[#1a1030] shadow-xl shadow-coral/30">
        <div aria-hidden="true" class="absolute -right-8 -top-10 size-36 rounded-full bg-white/20"></div>
        <div class="relative text-[13px] font-bold text-[#3a1b2e]">Total jimpitan hari ini</div>
        <div class="relative mb-4 mt-1 text-4xl font-extrabold tracking-tight">{{ Fmt::rp($totalHariIni) }}</div>
        <div class="relative mb-2 flex justify-between text-[13px] font-bold">
            <span>{{ $sudah }} dari {{ $wargaAktif }} warga tercatat</span>
            <span>{{ $persen }}%</span>
        </div>
        <div class="relative h-2.5 rounded-full bg-[#1a1030]/20" role="progressbar" aria-valuenow="{{ $persen }}" aria-valuemin="0" aria-valuemax="100">
            <div class="h-2.5 rounded-full bg-[#1a1030]" style="width: {{ $persen }}%"></div>
        </div>
    </section>

    <a href="{{ route('scan') }}" class="btn btn-cool h-[60px] text-[17px]">
        <x-icon name="qr" class="size-6" />
        Scan Warga
    </a>

    <section class="grid grid-cols-3 gap-2.5">
        <div class="card !px-3">
            <div class="flex size-[30px] items-center justify-center rounded-[10px] bg-mint/15 text-mint"><x-icon name="users" class="size-4" /></div>
            <div class="mt-2.5 text-2xl font-extrabold text-mint">{{ $wargaAktif }}</div>
            <div class="text-xs text-muted">Warga aktif</div>
        </div>
        <div class="card !px-3">
            <div class="flex size-[30px] items-center justify-center rounded-[10px] bg-lilac/15 text-lilac"><x-icon name="check" class="size-4" /></div>
            <div class="mt-2.5 text-2xl font-extrabold text-lilac">{{ $sudah }}</div>
            <div class="text-xs text-muted">Sudah</div>
        </div>
        <div class="card !px-3">
            <div class="flex size-[30px] items-center justify-center rounded-[10px] bg-blush/15 text-blush"><x-icon name="clock" class="size-4" /></div>
            <div class="mt-2.5 text-2xl font-extrabold text-blush">{{ $belum }}</div>
            <div class="text-xs text-muted">Belum</div>
        </div>
    </section>

    <section>
        <div class="mb-2.5 flex items-center justify-between">
            <h2 class="text-[17px] font-bold">Transaksi terakhir</h2>
            <a href="{{ route('jimpitan.index') }}" class="text-[13px] font-bold text-sun">Lihat semua</a>
        </div>

        <div class="card divide-y divide-edge !px-4 !py-1">
            @forelse ($terakhir as $t)
                <div class="flex items-center gap-3 py-3">
                    <x-avatar :warga="$t->warga" />
                    <div class="min-w-0 flex-1">
                        <div class="truncate text-[15px] font-semibold">{{ $t->warga->nama }}</div>
                        <div class="text-xs text-muted">Rumah {{ $t->warga->no_rumah }} · {{ $t->created_at->format('H.i') }}</div>
                    </div>
                    <div class="text-[15px] font-extrabold text-mint">{{ Fmt::rp($t->nominal) }}</div>
                </div>
            @empty
                <p class="py-6 text-center text-sm text-muted">Belum ada transaksi. Mulai dengan menekan Scan Warga.</p>
            @endforelse
        </div>
    </section>
@endsection

{{-- Navigasi bawah: Home, Warga, Scan (menonjol), Rekap, Lainnya --}}
@php
    $aktif = fn (string ...$rute) => request()->routeIs(...$rute);
@endphp

<nav aria-label="Navigasi utama" class="tanpa-cetak fixed inset-x-0 bottom-0 z-30 mx-auto flex h-[84px] max-w-md items-center justify-around border-t border-edge bg-ink-900 px-2 pb-2">
    <a href="{{ route('dashboard') }}" @if ($aktif('dashboard')) aria-current="page" @endif
       class="flex w-16 flex-col items-center gap-1 pt-3 text-[11px] {{ $aktif('dashboard') ? 'font-bold text-sun' : 'font-semibold text-muted' }}">
        <x-icon name="home" />
        Home
    </a>

    <a href="{{ route('warga.index') }}" @if ($aktif('warga.*')) aria-current="page" @endif
       class="flex w-16 flex-col items-center gap-1 pt-3 text-[11px] {{ $aktif('warga.*') ? 'font-bold text-blush' : 'font-semibold text-muted' }}">
        <x-icon name="users" />
        Warga
    </a>

    <a href="{{ route('scan') }}" aria-label="Scan Warga" @if ($aktif('scan', 'jimpitan.create')) aria-current="page" @endif
       class="-mt-9 flex w-[72px] flex-col items-center gap-1 text-[11px] font-bold text-mint">
        <span class="flex size-[62px] items-center justify-center rounded-full border-4 border-ink-950 bg-linear-to-br from-mint to-iris text-ink-950 shadow-lg shadow-mint/40">
            <x-icon name="qr" class="size-7" />
        </span>
        Scan
    </a>

    <a href="{{ route('laporan.index') }}" @if ($aktif('laporan.*')) aria-current="page" @endif
       class="flex w-16 flex-col items-center gap-1 pt-3 text-[11px] {{ $aktif('laporan.*') ? 'font-bold text-mint' : 'font-semibold text-muted' }}">
        <x-icon name="chart" />
        Rekap
    </a>

    <a href="{{ route('lainnya') }}" @if ($aktif('lainnya', 'jimpitan.index', 'pengaturan.*', 'petugas.*')) aria-current="page" @endif
       class="flex w-16 flex-col items-center gap-1 pt-3 text-[11px] {{ $aktif('lainnya', 'jimpitan.index', 'pengaturan.*', 'petugas.*') ? 'font-bold text-lilac' : 'font-semibold text-muted' }}">
        <x-icon name="grid" />
        Lainnya
    </a>
</nav>

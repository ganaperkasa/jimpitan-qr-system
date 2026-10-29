@extends('layouts.app')

@section('title', 'Data Warga')

@section('content')
    <header class="flex items-center justify-between">
        <div>
            <h1 class="text-[26px] font-extrabold">Data Warga</h1>
            <div class="text-[13px] text-muted">{{ $jumlahAktif }} warga aktif</div>
        </div>
        @if (auth()->user()->isAdmin())
            <a href="{{ route('warga.create') }}" aria-label="Tambah warga" class="flex size-12 items-center justify-center rounded-full bg-linear-to-br from-blush to-sun text-ink-950 shadow-lg shadow-blush/30">
                <x-icon name="plus" class="size-6" />
            </a>
        @endif
    </header>

    <form method="GET" class="relative">
        <label for="q" class="sr-only">Cari warga</label>
        <x-icon name="search" class="pointer-events-none absolute left-4 top-[15px] size-5 text-muted" />
        <input id="q" name="q" type="search" value="{{ $q }}" placeholder="Cari nama, kode, atau no. rumah" class="field !h-[50px] !pl-12">
        @if ($status) <input type="hidden" name="status" value="{{ $status }}"> @endif
    </form>

    <nav aria-label="Filter status" class="flex gap-2">
        <a href="{{ route('warga.index', array_filter(['q' => $q])) }}" class="rounded-full px-4 py-2 text-[13px] {{ ! $status ? 'bg-blush font-extrabold text-ink-950' : 'border border-edge-strong bg-ink-800 font-bold text-soft' }}">Semua</a>
        <a href="{{ route('warga.index', array_filter(['q' => $q, 'status' => 'aktif'])) }}" class="rounded-full px-4 py-2 text-[13px] {{ $status === 'aktif' ? 'bg-mint font-extrabold text-ink-950' : 'border border-edge-strong bg-ink-800 font-bold text-mint' }}">Aktif</a>
        <a href="{{ route('warga.index', array_filter(['q' => $q, 'status' => 'nonaktif'])) }}" class="rounded-full px-4 py-2 text-[13px] {{ $status === 'nonaktif' ? 'bg-lilac font-extrabold text-ink-950' : 'border border-edge-strong bg-ink-800 font-bold text-lilac' }}">Nonaktif</a>
    </nav>

    <section class="space-y-2.5">
        @forelse ($warga as $w)
            @php $admin = auth()->user()->isAdmin(); @endphp
            <div class="card relative flex items-center gap-3 !p-3.5">
                <x-avatar :warga="$w" class="!size-[46px]" />
                <div class="min-w-0 flex-1">
                    <div class="truncate text-base font-bold {{ $w->aktif ? '' : 'text-soft' }}">
                        @if ($admin)
                            {{-- Tautan membentang ke seluruh kartu agar mudah disentuh --}}
                            <a href="{{ route('warga.show', $w) }}" class="after:absolute after:inset-0">{{ $w->nama }}</a>
                        @else
                            {{ $w->nama }}
                        @endif
                    </div>
                    <div class="text-xs text-muted">Rumah {{ $w->no_rumah }} · {{ $w->kode_warga }}</div>
                </div>
                <span class="chip {{ $w->aktif ? 'bg-mint/15 text-mint' : 'bg-muted/20 text-soft' }}">{{ $w->aktif ? 'Aktif' : 'Nonaktif' }}</span>
                @if ($admin) <x-icon name="chevron" class="size-5 text-muted" /> @endif
            </div>
        @empty
            <p class="card py-8 text-center text-sm text-muted">Tidak ada warga yang cocok.</p>
        @endforelse
    </section>

    {{ $warga->links() }}

    @if (auth()->user()->isAdmin())
        <a href="{{ route('warga.cetak') }}" target="_blank" class="btn btn-outline">
            <x-icon name="print" class="size-5" />
            Cetak semua QR
        </a>
    @endif
@endsection

@extends('layouts.app')

@use('App\Support\Fmt')

@section('title', 'Rekap')

@section('content')
    <header>
        <h1 class="text-[26px] font-extrabold">Rekap</h1>
        <div class="text-[13px] text-muted">
            {{ $mode === 'harian' ? Fmt::tanggal($tanggal, 'l, j F Y') : Fmt::tanggal($bulan, 'F Y') }}
        </div>
    </header>

    <nav aria-label="Jenis rekap" class="flex rounded-2xl border border-edge bg-ink-800 p-1">
        @foreach (['harian' => 'Harian', 'bulanan' => 'Bulanan', 'warga' => 'Per Warga'] as $kunci => $nama)
            <a href="{{ route('laporan.index', ['mode' => $kunci, 'tanggal' => $tanggal->toDateString(), 'bulan' => $bulan->format('Y-m')]) }}"
               @if ($mode === $kunci) aria-current="page" @endif
               class="flex h-10 flex-1 items-center justify-center rounded-xl text-[13px] {{ $mode === $kunci ? 'bg-mint font-extrabold text-ink-950' : 'font-bold text-soft' }}">
                {{ $nama }}
            </a>
        @endforeach
    </nav>

    <form method="GET" class="flex gap-2.5">
        <input type="hidden" name="mode" value="{{ $mode }}">
        @if ($mode === 'harian')
            <label for="tanggal" class="sr-only">Tanggal</label>
            <input id="tanggal" name="tanggal" type="date" value="{{ $tanggal->toDateString() }}" max="{{ today()->toDateString() }}" class="field !h-11 min-w-0 flex-1 [color-scheme:dark]">
        @else
            <label for="bulan" class="sr-only">Bulan</label>
            <input id="bulan" name="bulan" type="month" value="{{ $bulan->format('Y-m') }}" class="field !h-11 min-w-0 flex-1 [color-scheme:dark]">
        @endif
        <button type="submit" class="h-11 shrink-0 rounded-2xl bg-sun px-5 text-[15px] font-extrabold text-ink-950">Tampilkan</button>
    </form>

    <section class="relative overflow-hidden rounded-[26px] bg-linear-to-br from-mint to-iris p-5 text-ink-950 shadow-xl shadow-mint/25">
        <div aria-hidden="true" class="absolute -right-8 -top-10 size-36 rounded-full bg-white/20"></div>
        <div class="relative text-[13px] font-bold">{{ $mode === 'harian' ? 'Total hari ini' : 'Total bulan ini' }}</div>
        <div class="relative mt-1 text-4xl font-extrabold tracking-tight">{{ Fmt::rp($total) }}</div>
        @if ($mode === 'harian')
            <div class="relative mt-1 text-[13px] font-bold">{{ $transaksi->count() }} catatan</div>
        @elseif ($mode === 'bulanan')
            <div class="relative mt-1 text-[13px] font-bold">{{ $perHari->count() }} hari tercatat</div>
        @endif
    </section>

    {{-- ===== HARIAN ===== --}}
    @if ($mode === 'harian')
        <section>
            <h2 class="mb-2.5 text-[17px] font-bold">Transaksi</h2>
            <div class="card divide-y divide-edge !px-4 !py-1">
                @forelse ($transaksi as $t)
                    <div class="flex items-center gap-3 py-3">
                        <x-avatar :warga="$t->warga" class="!size-10" />
                        <div class="min-w-0 flex-1">
                            <div class="truncate text-[15px] font-semibold">{{ $t->warga->nama }}</div>
                            <div class="text-xs text-muted">Rumah {{ $t->warga->no_rumah }} · {{ $t->created_at->format('H.i') }} · {{ $t->petugas->name }}</div>
                        </div>
                        <div class="text-[15px] font-extrabold text-mint">{{ Fmt::rp($t->nominal) }}</div>
                    </div>
                @empty
                    <p class="py-6 text-center text-sm text-muted">Belum ada transaksi pada tanggal ini.</p>
                @endforelse
            </div>
        </section>

        <section>
            <div class="mb-2.5 flex items-center justify-between">
                <h2 class="text-[17px] font-bold">Belum tercatat</h2>
                <span class="chip bg-blush/15 !text-xs text-blush">{{ $belumTercatat->count() }} warga</span>
            </div>
            <div class="card divide-y divide-edge !px-4 !py-1">
                @forelse ($belumTercatat as $w)
                    <div class="flex items-center gap-3 py-3">
                        <x-avatar :warga="$w" class="!size-10" />
                        <div class="min-w-0 flex-1">
                            <div class="truncate text-[15px] font-semibold">{{ $w->nama }}</div>
                            <div class="text-xs text-muted">Rumah {{ $w->no_rumah }}</div>
                        </div>
                        <a href="{{ route('jimpitan.create', ['kode' => $w->kode_warga]) }}" class="rounded-full bg-sun/15 px-3.5 py-2 text-xs font-extrabold text-sun">Catat</a>
                    </div>
                @empty
                    <p class="py-6 text-center text-sm text-muted">Semua warga aktif sudah tercatat.</p>
                @endforelse
            </div>
        </section>
    @endif

    {{-- ===== BULANAN ===== --}}
    @if ($mode === 'bulanan')
        <section>
            <h2 class="mb-2.5 text-[17px] font-bold">Per tanggal</h2>
            <div class="card divide-y divide-edge !px-4 !py-1">
                @forelse ($perHari as $h)
                    <a href="{{ route('laporan.index', ['mode' => 'harian', 'tanggal' => \Illuminate\Support\Carbon::parse($h->tanggal)->toDateString()]) }}" class="flex items-center justify-between gap-3 py-3">
                        <div>
                            <div class="text-[15px] font-semibold">{{ Fmt::tanggal($h->tanggal, 'l, j M') }}</div>
                            <div class="text-xs text-muted">{{ $h->jumlah }} catatan</div>
                        </div>
                        <div class="text-[15px] font-extrabold text-mint">{{ Fmt::rp($h->total) }}</div>
                    </a>
                @empty
                    <p class="py-6 text-center text-sm text-muted">Belum ada transaksi pada bulan ini.</p>
                @endforelse
            </div>
        </section>
    @endif

    {{-- ===== PER WARGA ===== --}}
    @if ($mode === 'warga')
        <section>
            <h2 class="mb-2.5 text-[17px] font-bold">Total per warga</h2>
            <div class="card divide-y divide-edge !px-4 !py-1">
                @forelse ($perWarga as $w)
                    <div class="flex items-center gap-3 py-3 {{ $w->aktif ? '' : 'opacity-60' }}">
                        <x-avatar :warga="$w" class="!size-10" />
                        <div class="min-w-0 flex-1">
                            <div class="truncate text-[15px] font-semibold">{{ $w->nama }}</div>
                            <div class="text-xs text-muted">Rumah {{ $w->no_rumah }} · {{ $w->jumlah }} catatan</div>
                        </div>
                        <div class="text-[15px] font-extrabold {{ $w->total > 0 ? 'text-mint' : 'text-muted' }}">{{ Fmt::rp($w->total) }}</div>
                    </div>
                @empty
                    <p class="py-6 text-center text-sm text-muted">Belum ada data warga.</p>
                @endforelse
            </div>
        </section>
    @endif

    <button type="button" onclick="window.print()" class="tanpa-cetak btn btn-outline !border-mint !text-mint">
        <x-icon name="print" class="size-5" />
        Cetak rekap
    </button>
@endsection

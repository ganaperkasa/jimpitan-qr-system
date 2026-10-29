@extends('layouts.app')

@use('App\Support\Fmt')

@section('title', 'Riwayat Transaksi')

@section('content')
    <x-judul judul="Riwayat Transaksi" :kembali="route('lainnya')" />

    <form method="GET" class="card space-y-3">
        <div class="grid grid-cols-2 gap-2.5">
            <div>
                <label for="dari" class="label">Dari</label>
                <input id="dari" name="dari" type="date" value="{{ $dari }}" class="field !h-11 [color-scheme:dark]">
            </div>
            <div>
                <label for="sampai" class="label">Sampai</label>
                <input id="sampai" name="sampai" type="date" value="{{ $sampai }}" class="field !h-11 [color-scheme:dark]">
            </div>
        </div>
        <div>
            <label for="q" class="label">Warga (nama, kode, atau no. rumah)</label>
            <input id="q" name="q" type="search" value="{{ $cari }}" placeholder="Cari warga" class="field !h-11">
        </div>
        <button type="submit" class="btn btn-cool !h-11 !text-[15px]">Terapkan filter</button>
    </form>

    <div class="flex items-center justify-between rounded-2xl bg-linear-to-r from-mint/15 to-iris/15 px-4 py-3">
        <span class="text-[13px] font-semibold text-soft">Total tercatat pada periode</span>
        <span class="text-lg font-extrabold text-mint">{{ Fmt::rp($total) }}</span>
    </div>

    <section class="space-y-2.5">
        @forelse ($transaksi as $t)
            <article class="card !p-3.5 {{ $t->dibatalkan ? 'opacity-70' : '' }}">
                <div class="flex items-center gap-3">
                    <x-avatar :warga="$t->warga" />
                    <div class="min-w-0 flex-1">
                        <div class="truncate text-[15px] font-semibold">{{ $t->warga->nama }}</div>
                        <div class="text-xs text-muted">
                            Rumah {{ $t->warga->no_rumah }} · {{ Fmt::tanggal($t->tanggal, 'j M') }} {{ $t->created_at->format('H.i') }} · {{ $t->petugas->name }}
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-[15px] font-extrabold {{ $t->dibatalkan ? 'text-muted line-through' : 'text-mint' }}">{{ Fmt::rp($t->nominal) }}</div>
                        @if ($t->dibatalkan)
                            <span class="chip bg-blush/15 text-blush">Dibatalkan</span>
                        @endif
                    </div>
                </div>

                @if ($t->catatan)
                    <p class="mt-2 text-[13px] text-soft">Catatan: {{ $t->catatan }}</p>
                @endif

                @if (auth()->user()->isAdmin() && ! $t->dibatalkan)
                    <details class="mt-2.5 border-t border-edge pt-2.5">
                        <summary class="cursor-pointer text-[13px] font-bold text-blush">Batalkan transaksi</summary>
                        <form method="POST" action="{{ route('jimpitan.batal', $t) }}" class="mt-2.5 space-y-2.5">
                            @csrf
                            <label for="alasan-{{ $t->id }}" class="label">Alasan pembatalan</label>
                            <textarea id="alasan-{{ $t->id }}" name="alasan" rows="2" required minlength="5" maxlength="255" class="field-area" placeholder="Contoh: salah nominal"></textarea>
                            <button type="submit" class="h-11 w-full rounded-2xl bg-blush text-[15px] font-extrabold text-ink-950">Batalkan dan catat di log</button>
                        </form>
                    </details>
                @endif
            </article>
        @empty
            <p class="card py-8 text-center text-sm text-muted">Tidak ada transaksi pada filter ini.</p>
        @endforelse
    </section>

    @error('alasan') <p class="error-text">{{ $message }}</p> @enderror

    {{ $transaksi->links() }}
@endsection

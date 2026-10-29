@extends('layouts.app')

@section('title', $warga->nama)

@section('content')
    <x-judul :judul="$warga->nama" :kembali="route('warga.index')">
        <a href="{{ route('warga.edit', $warga) }}" aria-label="Ubah data warga" class="flex size-[42px] items-center justify-center rounded-full border border-edge bg-ink-800 text-sun">
            <x-icon name="edit" class="size-5" />
        </a>
    </x-judul>

    <section class="flex flex-col items-center gap-4 rounded-[26px] bg-linear-to-br from-mint to-iris p-6 text-ink-950 shadow-xl shadow-mint/20">
        <div class="rounded-3xl bg-white p-3" role="img" aria-label="QR Code {{ $warga->kode_warga }}">
            {{ \App\Support\QrSvg::make($warga->kode_warga, 200) }}
        </div>
        <div class="text-center">
            <div class="text-lg font-extrabold tracking-wide">{{ $warga->kode_warga }}</div>
            <div class="text-sm font-semibold">{{ $warga->nama }} · Rumah {{ $warga->no_rumah }}</div>
        </div>
        <p class="text-center text-xs font-semibold">QR hanya berisi kode internal, tanpa data pribadi, dan bukan bukti pembayaran.</p>
    </section>

    <section class="card space-y-3 text-sm">
        <div class="flex justify-between gap-4"><span class="text-muted">Status</span>
            <span class="chip {{ $warga->aktif ? 'bg-mint/15 text-mint' : 'bg-muted/20 text-soft' }}">{{ $warga->aktif ? 'Aktif' : 'Nonaktif' }}</span></div>
        <div class="flex justify-between gap-4"><span class="text-muted">Alamat</span><span class="text-right font-semibold">{{ $warga->alamat ?: '-' }}</span></div>
        <div class="flex justify-between gap-4"><span class="text-muted">Nomor HP</span><span class="text-right font-semibold">{{ $warga->no_hp ?: '-' }}</span></div>
    </section>

    <a href="{{ route('warga.cetak', ['id' => $warga->id]) }}" target="_blank" class="btn btn-cool">
        <x-icon name="print" class="size-5" />
        Cetak QR warga ini
    </a>

    <form method="POST" action="{{ route('warga.status', $warga) }}">
        @csrf
        @method('PATCH')
        <button type="submit" class="btn btn-outline !border-blush !text-blush">
            {{ $warga->aktif ? 'Nonaktifkan warga' : 'Aktifkan kembali' }}
        </button>
    </form>
@endsection

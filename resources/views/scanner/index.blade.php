@extends('layouts.app')

@section('title', 'Scan Warga')

@section('content')
    <x-judul judul="Scan Warga" :kembali="route('dashboard')" />

    @if (session('berhasil'))
        @php $b = session('berhasil'); @endphp
        <div role="status" class="rounded-3xl border border-mint bg-mint/10 p-4">
            <div class="flex items-center gap-3">
                <span class="flex size-11 items-center justify-center rounded-full bg-mint text-ink-950"><x-icon name="check" class="size-6" /></span>
                <div class="min-w-0 flex-1">
                    <div class="font-bold text-mint">Jimpitan tersimpan</div>
                    <div class="truncate text-sm text-soft">{{ $b['nama'] }} · Rumah {{ $b['rumah'] }} · {{ $b['nominal'] }}</div>
                </div>
            </div>
        </div>
    @endif

    <div x-data="pemindai('{{ route('jimpitan.create') }}')" x-init="mulai()" x-on:beforeunload.window="berhenti()" class="space-y-4">
        <div class="flex flex-col items-center gap-3.5">
            <div class="relative aspect-square w-full max-w-[300px] overflow-hidden rounded-[28px] border border-edge bg-linear-to-br from-[#1b2147] to-[#121530]">
                <div id="area-kamera" class="absolute inset-0 [&_video]:size-full [&_video]:object-cover"></div>

                {{-- Sudut bingkai berwarna --}}
                <div aria-hidden="true" class="pointer-events-none absolute left-3 top-3 size-11 rounded-tl-[20px] border-l-[5px] border-t-[5px] border-mint"></div>
                <div aria-hidden="true" class="pointer-events-none absolute right-3 top-3 size-11 rounded-tr-[20px] border-r-[5px] border-t-[5px] border-sun"></div>
                <div aria-hidden="true" class="pointer-events-none absolute bottom-3 left-3 size-11 rounded-bl-[20px] border-b-[5px] border-l-[5px] border-blush"></div>
                <div aria-hidden="true" class="pointer-events-none absolute bottom-3 right-3 size-11 rounded-br-[20px] border-b-[5px] border-r-[5px] border-lilac"></div>
                <div x-show="status === 'aktif'" aria-hidden="true" class="pointer-events-none absolute inset-x-6 h-1 rounded-full bg-linear-to-r from-mint via-iris to-blush shadow-[0_0_18px_rgba(46,230,197,.8)]" style="animation: sapu 3.2s ease-in-out infinite"></div>

                <div x-show="status !== 'aktif'" class="absolute inset-0 flex flex-col items-center justify-center gap-3 p-6 text-center">
                    <x-icon name="qr" class="size-16 text-edge-strong" />
                    <p class="text-sm text-soft" x-show="status === 'memuat'">Membuka kamera...</p>
                    <p class="text-sm text-blush" x-show="status === 'gagal'" x-text="pesan"></p>
                    <button type="button" x-show="status === 'gagal'" x-on:click="status = 'diam'; mulai()" class="rounded-full bg-sun px-5 py-2 text-sm font-extrabold text-ink-950">Coba lagi</button>
                </div>
            </div>
            <p class="text-[15px] text-soft">Arahkan kamera ke QR Code warga</p>
        </div>

        <form method="GET" action="{{ route('jimpitan.create') }}" class="space-y-2">
            <label for="kode" class="label">Kamera bermasalah? Masukkan kode manual</label>
            <div class="flex gap-2.5">
                <input id="kode" name="kode" type="text" autocomplete="off" autocapitalize="characters" placeholder="WARGA-000123" class="field min-w-0 flex-1 !h-[50px]">
                <button type="submit" class="h-[50px] shrink-0 rounded-2xl bg-sun px-5 text-[15px] font-extrabold text-ink-950">Cari</button>
            </div>
        </form>
    </div>
@endsection

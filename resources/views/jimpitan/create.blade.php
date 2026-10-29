@extends('layouts.app')

@use('App\Support\Fmt')

@section('title', 'Catat Jimpitan')
@section('tanpa-nav', '1')

@section('content')
    <x-judul judul="Catat Jimpitan" :kembali="route('scan')" />

    <section class="flex items-center gap-4 rounded-[26px] bg-linear-to-br from-iris to-hot p-5 text-[#12102a] shadow-xl shadow-iris/30">
        <div class="flex size-16 shrink-0 items-center justify-center rounded-full bg-[#12102a] text-[22px] font-extrabold text-sun">{{ $warga->inisial }}</div>
        <div class="min-w-0 flex-1">
            <div class="truncate text-[22px] font-extrabold leading-tight">{{ $warga->nama }}</div>
            <div class="text-sm font-semibold">Rumah No. {{ $warga->no_rumah }}</div>
            <div class="mt-2 flex gap-1.5">
                <span class="chip bg-[#12102a]/85 text-snow">{{ $warga->kode_warga }}</span>
                <span class="chip bg-[#12102a]/85 text-mint">Aktif</span>
            </div>
        </div>
    </section>

    {{-- Boleh lebih dari sekali per hari: hanya peringatan, bukan penolakan. --}}
    @if ($hariIni->isNotEmpty())
        <div role="status" class="flex items-start gap-3 rounded-2xl border border-sun/50 bg-sun/10 p-3.5 text-sm text-sun">
            <x-icon name="alert" class="mt-0.5 size-5 shrink-0" />
            <span>
                <strong class="font-extrabold">Sudah tercatat hari ini:</strong>
                {{ $hariIni->map(fn ($j) => Fmt::rp($j->nominal))->implode(', ') }}.
                Anda tetap bisa menambah catatan baru.
            </span>
        </div>
    @endif

    <form method="POST" action="{{ route('jimpitan.store') }}"
          x-data="{ kirim: false, ...nominal('{{ number_format((int) preg_replace('/\D/', '', (string) old('nominal', $setting->nominal_default)), 0, ',', '.') }}') }"
          x-on:submit="kirim = true" class="space-y-4">
        @csrf
        <input type="hidden" name="warga_id" value="{{ $warga->id }}">
        <input type="hidden" name="token" value="{{ $token }}">

        <div>
            <label for="nominal" class="label">Nominal</label>
            <div class="flex h-[68px] items-center gap-2.5 rounded-[20px] border-2 border-sun bg-field px-4">
                <span class="text-[22px] font-bold text-sun">Rp</span>
                <input id="nominal" name="nominal" type="text" inputmode="numeric" autocomplete="off" required
                       x-model="nilai" x-on:input="nilai = format(nilai)"
                       class="min-w-0 flex-1 border-0 bg-transparent text-[32px] font-extrabold text-snow outline-none">
            </div>
            @error('nominal') <p class="error-text">{{ $message }}</p> @enderror

            <div class="mt-2.5 grid grid-cols-2 gap-2.5">
                @foreach ($setting->nominalCepat() as $i => $n)
                    <button type="button" x-on:click="atur({{ $n }})"
                            class="h-[52px] rounded-2xl border border-edge-strong bg-ink-800 text-base font-extrabold {{ ['text-mint', 'text-sun', 'text-lilac', 'text-blush'][$i % 4] }}">
                        {{ Fmt::rp($n) }}
                    </button>
                @endforeach
            </div>
        </div>

        <div class="grid grid-cols-2 gap-2.5">
            <div class="card !px-3.5 !py-3">
                <label for="tanggal" class="text-xs text-muted">Tanggal</label>
                <input id="tanggal" name="tanggal" type="date" value="{{ old('tanggal', today()->toDateString()) }}" max="{{ today()->toDateString() }}"
                       class="mt-0.5 block w-full border-0 bg-transparent p-0 text-[15px] font-bold text-mint outline-none [color-scheme:dark]">
            </div>
            <div class="card !px-3.5 !py-3">
                <div class="text-xs text-muted">Petugas</div>
                <div class="mt-0.5 truncate text-[15px] font-bold text-lilac">{{ auth()->user()->name }}</div>
            </div>
        </div>
        @error('tanggal') <p class="error-text">{{ $message }}</p> @enderror

        <div>
            <label for="catatan" class="label">Catatan (opsional)</label>
            <input id="catatan" name="catatan" type="text" maxlength="255" value="{{ old('catatan') }}" placeholder="Contoh: titip ke tetangga" class="field !h-[50px]">
            @error('catatan') <p class="error-text">{{ $message }}</p> @enderror
        </div>

        <button type="submit" x-bind:disabled="kirim" class="btn btn-warm h-[60px] text-[17px]">
            <x-icon name="check" class="size-[22px]" />
            <span x-text="kirim ? 'Menyimpan...' : 'Simpan Jimpitan'">Simpan Jimpitan</span>
        </button>
    </form>
@endsection

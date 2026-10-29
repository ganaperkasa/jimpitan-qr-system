@extends('layouts.app')

@section('title', 'Pengaturan')

@section('content')
    <x-judul judul="Pengaturan" :kembali="route('lainnya')" />

    <form method="POST" action="{{ route('pengaturan.update') }}" class="card space-y-4 !p-5">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-2 gap-2.5">
            <div>
                <label for="nama_rt" class="label">RT</label>
                <input id="nama_rt" name="nama_rt" type="text" required maxlength="50" value="{{ old('nama_rt', $setting->nama_rt) }}" class="field">
                @error('nama_rt') <p class="error-text">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="nama_rw" class="label">RW</label>
                <input id="nama_rw" name="nama_rw" type="text" required maxlength="50" value="{{ old('nama_rw', $setting->nama_rw) }}" class="field">
                @error('nama_rw') <p class="error-text">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label for="desa" class="label">Desa/kelurahan</label>
            <input id="desa" name="desa" type="text" maxlength="100" value="{{ old('desa', $setting->desa) }}" class="field">
        </div>

        <div>
            <label for="kecamatan" class="label">Kecamatan</label>
            <input id="kecamatan" name="kecamatan" type="text" maxlength="100" value="{{ old('kecamatan', $setting->kecamatan) }}" class="field">
        </div>

        <div>
            <label for="nominal_default" class="label">Nominal awal di form (saran)</label>
            <input id="nominal_default" name="nominal_default" type="number" inputmode="numeric" min="1" required value="{{ old('nominal_default', $setting->nominal_default) }}" class="field">
            <p class="mt-1.5 text-xs text-muted">Nominal tidak tetap. Petugas selalu bisa mengubahnya saat mencatat.</p>
            @error('nominal_default') <p class="error-text">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="nominal_cepat" class="label">Tombol nominal cepat</label>
            <input id="nominal_cepat" name="nominal_cepat" type="text" required value="{{ old('nominal_cepat', $setting->nominal_cepat) }}" class="field">
            <p class="mt-1.5 text-xs text-muted">Angka dipisah koma, misalnya 1000,2000,5000,10000.</p>
            @error('nominal_cepat') <p class="error-text">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="btn btn-warm">Simpan pengaturan</button>
    </form>
@endsection

{{-- Formulir bersama untuk tambah dan ubah warga. $warga null saat tambah. --}}
@php $w = $warga ?? null; @endphp

<div>
    <label for="nama" class="label">Nama warga</label>
    <input id="nama" name="nama" type="text" required maxlength="100" value="{{ old('nama', $w?->nama) }}" class="field">
    @error('nama') <p class="error-text">{{ $message }}</p> @enderror
</div>

<div>
    <label for="no_rumah" class="label">Nomor rumah</label>
    <input id="no_rumah" name="no_rumah" type="text" required maxlength="20" value="{{ old('no_rumah', $w?->no_rumah) }}" class="field">
    @error('no_rumah') <p class="error-text">{{ $message }}</p> @enderror
</div>

<div>
    <label for="alamat" class="label">Alamat (opsional)</label>
    <input id="alamat" name="alamat" type="text" maxlength="255" value="{{ old('alamat', $w?->alamat) }}" class="field">
    @error('alamat') <p class="error-text">{{ $message }}</p> @enderror
</div>

<div>
    <label for="no_hp" class="label">Nomor HP (opsional)</label>
    <input id="no_hp" name="no_hp" type="tel" inputmode="tel" maxlength="20" value="{{ old('no_hp', $w?->no_hp) }}" class="field">
    @error('no_hp') <p class="error-text">{{ $message }}</p> @enderror
</div>

@if ($w)
    <div>
        <label for="status" class="label">Status</label>
        <select id="status" name="status" class="field">
            <option value="aktif" @selected(old('status', $w->status) === 'aktif')>Aktif</option>
            <option value="nonaktif" @selected(old('status', $w->status) === 'nonaktif')>Nonaktif</option>
        </select>
        @error('status') <p class="error-text">{{ $message }}</p> @enderror
    </div>
@endif

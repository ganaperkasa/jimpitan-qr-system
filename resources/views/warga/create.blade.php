@extends('layouts.app')

@section('title', 'Tambah Warga')

@section('content')
    <x-judul judul="Tambah Warga" :kembali="route('warga.index')" />

    <form method="POST" action="{{ route('warga.store') }}" class="card space-y-4 !p-5">
        @csrf
        @include('warga._form')
        <p class="text-[13px] text-muted">Kode warga dan QR Code dibuat otomatis setelah disimpan.</p>
        <button type="submit" class="btn btn-warm">Simpan warga</button>
    </form>
@endsection

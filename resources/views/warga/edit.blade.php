@extends('layouts.app')

@section('title', 'Ubah Warga')

@section('content')
    <x-judul judul="Ubah Data Warga" :kembali="route('warga.show', $warga)" />

    <form method="POST" action="{{ route('warga.update', $warga) }}" class="card space-y-4 !p-5">
        @csrf
        @method('PUT')
        @include('warga._form', ['warga' => $warga])
        <button type="submit" class="btn btn-warm">Simpan perubahan</button>
    </form>
@endsection

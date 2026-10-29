@extends('layouts.app')

@section('title', 'Akun Petugas')

@section('content')
    <x-judul judul="Akun Pengguna" :kembali="route('lainnya')" />

    <section class="card divide-y divide-edge !px-4 !py-1">
        @foreach ($daftar as $u)
            <div class="flex items-center gap-3 py-3 {{ $u->aktif ? '' : 'opacity-60' }}">
                <div class="flex size-10 shrink-0 items-center justify-center rounded-full bg-lilac text-[13px] font-extrabold text-ink-950">{{ $u->inisial }}</div>
                <div class="min-w-0 flex-1">
                    <div class="truncate text-[15px] font-semibold">{{ $u->name }}</div>
                    <div class="truncate text-xs text-muted">{{ $u->email }} · {{ $u->isAdmin() ? 'Admin' : 'Petugas' }}</div>
                </div>
                @if ($u->id !== auth()->id())
                    <form method="POST" action="{{ route('petugas.status', $u) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="rounded-full px-3.5 py-2 text-xs font-extrabold {{ $u->aktif ? 'bg-blush/15 text-blush' : 'bg-mint/15 text-mint' }}">
                            {{ $u->aktif ? 'Nonaktifkan' : 'Aktifkan' }}
                        </button>
                    </form>
                @else
                    <span class="chip bg-mint/15 text-mint">Anda</span>
                @endif
            </div>
        @endforeach
    </section>

    <form method="POST" action="{{ route('petugas.store') }}" class="card space-y-4 !p-5">
        @csrf
        <h2 class="text-[17px] font-bold">Tambah petugas</h2>

        <div>
            <label for="name" class="label">Nama</label>
            <input id="name" name="name" type="text" required maxlength="100" value="{{ old('name') }}" class="field">
            @error('name') <p class="error-text">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="email" class="label">Email</label>
            <input id="email" name="email" type="email" required value="{{ old('email') }}" class="field">
            @error('email') <p class="error-text">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="password" class="label">Password (minimal 8 karakter)</label>
            <input id="password" name="password" type="password" required minlength="8" autocomplete="new-password" class="field">
            @error('password') <p class="error-text">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="btn btn-cool">Buat akun petugas</button>
    </form>
@endsection

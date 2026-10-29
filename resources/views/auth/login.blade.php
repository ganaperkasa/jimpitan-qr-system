@extends('layouts.app')

@section('title', 'Masuk')
@section('tanpa-nav', '1')

@section('content')
    <div class="flex flex-col items-center pt-10">
        <div class="flex size-[92px] items-center justify-center rounded-[30px] bg-linear-to-br from-sun via-coral to-hot text-[#1a1030] shadow-xl shadow-coral/40">
            <x-icon name="qr" class="size-12" />
        </div>
        <div class="mt-5 text-[40px] font-light tracking-tight">jimpi<span class="font-extrabold text-sun">t</span>an</div>
        <p class="mt-1 max-w-[260px] text-center text-[15px] leading-relaxed text-soft">Catat uang jimpitan warga dengan sekali scan.</p>
    </div>

    <form method="POST" action="{{ route('login.store') }}" class="card mt-6 space-y-4 !p-5">
        @csrf
        <h2 class="text-xl font-bold">Masuk ke akun</h2>

        <div>
            <label for="email" class="label">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="email" placeholder="nama@email.com" class="field">
            @error('email') <p class="error-text">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password" class="label">Password</label>
            <input id="password" name="password" type="password" required autocomplete="current-password" placeholder="Masukkan password" class="field">
            @error('password') <p class="error-text">{{ $message }}</p> @enderror
        </div>

        <label class="flex items-center gap-2 text-sm text-soft">
            <input type="checkbox" name="remember" value="1" class="size-4 rounded accent-sun">
            Tetap masuk di perangkat ini
        </label>

        <button type="submit" class="btn btn-warm">Masuk</button>
    </form>

    <p class="pt-2 text-center text-[13px] text-muted">Lupa password? Hubungi admin RT.</p>

    <div class="flex justify-center gap-2 pt-4">
        <span class="chip bg-mint/15 text-mint">Admin</span>
        <span class="chip bg-lilac/15 text-lilac">Petugas</span>
        <span class="chip bg-blush/15 text-blush">{{ $setting->nama_rt }} / {{ $setting->nama_rw }}</span>
    </div>
    <div class="flex justify-center gap-2 pt-1 text-center text-[13px] text-muted">
        <span>V1</span>
        <span class="text-soft">|</span>
        <span>GP Dev</span>
    </div>
@endsection

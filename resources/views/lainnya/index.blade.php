@extends('layouts.app')

@section('title', 'Lainnya')

@section('content')
    <header class="flex items-center gap-3.5">
        <div class="flex size-14 items-center justify-center rounded-full bg-linear-to-br from-lilac to-blush text-lg font-extrabold text-ink-950">{{ auth()->user()->inisial }}</div>
        <div class="min-w-0">
            <h1 class="truncate text-xl font-extrabold">{{ auth()->user()->name }}</h1>
            <div class="truncate text-[13px] text-muted">{{ auth()->user()->email }} · {{ auth()->user()->isAdmin() ? 'Admin' : 'Petugas' }}</div>
        </div>
    </header>

    <nav aria-label="Menu lainnya" class="card divide-y divide-edge !px-4 !py-1">
        <a href="{{ route('jimpitan.index') }}" class="flex items-center gap-3.5 py-3.5">
            <span class="flex size-10 items-center justify-center rounded-xl bg-sun/15 text-sun"><x-icon name="list" class="size-5" /></span>
            <span class="flex-1 text-[15px] font-semibold">Riwayat transaksi</span>
            <x-icon name="chevron" class="size-5 text-muted" />
        </a>

        @if (auth()->user()->isAdmin())
            <a href="{{ route('petugas.index') }}" class="flex items-center gap-3.5 py-3.5">
                <span class="flex size-10 items-center justify-center rounded-xl bg-lilac/15 text-lilac"><x-icon name="users" class="size-5" /></span>
                <span class="flex-1 text-[15px] font-semibold">Kelola akun petugas</span>
                <x-icon name="chevron" class="size-5 text-muted" />
            </a>
            <a href="{{ route('pengaturan.edit') }}" class="flex items-center gap-3.5 py-3.5">
                <span class="flex size-10 items-center justify-center rounded-xl bg-mint/15 text-mint"><x-icon name="settings" class="size-5" /></span>
                <span class="flex-1 text-[15px] font-semibold">Pengaturan RT dan nominal</span>
                <x-icon name="chevron" class="size-5 text-muted" />
            </a>
        @endif
    </nav>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-outline !border-blush !text-blush">
            <x-icon name="logout" class="size-5" />
            Keluar
        </button>
    </form>
@endsection

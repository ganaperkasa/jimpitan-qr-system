@props(['judul', 'kembali' => null])

{{-- Kepala halaman: tombol kembali opsional + judul --}}
<header class="flex items-center gap-3">
    @if ($kembali)
        <a href="{{ $kembali }}" aria-label="Kembali" class="flex size-[42px] items-center justify-center rounded-full border border-edge bg-ink-800 text-snow">
            <x-icon name="back" class="size-5" />
        </a>
    @endif
    <h1 class="min-w-0 flex-1 truncate text-xl font-bold">{{ $judul }}</h1>
    {{ $slot }}
</header>

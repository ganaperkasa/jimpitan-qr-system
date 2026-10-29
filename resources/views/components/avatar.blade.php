@props(['warga', 'ukuran' => 'size-11'])

@php
    // Warna avatar bergilir berdasarkan ID agar daftar terasa hidup.
    $warna = ['bg-sun', 'bg-blush', 'bg-mint', 'bg-lilac', 'bg-coral'][$warga->id % 5];
@endphp

<div aria-hidden="true" {{ $attributes->merge(['class' => "flex shrink-0 items-center justify-center rounded-full text-sm font-extrabold text-ink-950 $ukuran $warna"]) }}>
    {{ $warga->inisial }}
</div>

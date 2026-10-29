@props(['name'])

<svg {{ $attributes->merge(['class' => 'size-6']) }} viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
    @switch($name)
        @case('home')
            <path d="M3 11l9-8 9 8" /><path d="M5 10v10h14V10" /><path d="M10 20v-6h4v6" />
            @break
        @case('users')
            <circle cx="9" cy="8" r="3.5" /><path d="M2.5 20c0-3.6 2.9-6 6.5-6s6.5 2.4 6.5 6" /><circle cx="17.5" cy="9" r="2.5" /><path d="M17 14.2c2.6.2 4.5 2 4.5 4.8" />
            @break
        @case('qr')
            <rect x="3" y="3" width="7" height="7" rx="1.5" /><rect x="14" y="3" width="7" height="7" rx="1.5" /><rect x="3" y="14" width="7" height="7" rx="1.5" /><path d="M14 14h3v3h-3zM20 14v.01M14 20h3M20 17v4" />
            @break
        @case('chart')
            <rect x="4" y="11" width="4" height="9" rx="1" /><rect x="10" y="4" width="4" height="16" rx="1" /><rect x="16" y="8" width="4" height="12" rx="1" />
            @break
        @case('grid')
            <rect x="4" y="4" width="6" height="6" rx="1.5" /><rect x="14" y="4" width="6" height="6" rx="1.5" /><rect x="4" y="14" width="6" height="6" rx="1.5" /><rect x="14" y="14" width="6" height="6" rx="1.5" />
            @break
        @case('back')
            <path d="M15 5l-7 7 7 7" />
            @break
        @case('plus')
            <path d="M12 5v14M5 12h14" />
            @break
        @case('search')
            <circle cx="11" cy="11" r="7" /><path d="M20 20l-3.5-3.5" />
            @break
        @case('check')
            <path d="M5 12.5l4.5 4.5L19 7.5" />
            @break
        @case('alert')
            <path d="M12 3l10 18H2L12 3z" /><path d="M12 10v4M12 17.5v.01" />
            @break
        @case('print')
            <path d="M6 9V3h12v6" /><rect x="3" y="9" width="18" height="9" rx="2" /><path d="M7 15h10v6H7z" />
            @break
        @case('download')
            <path d="M12 4v11" /><path d="M7 11l5 5 5-5" /><path d="M4 20h16" />
            @break
        @case('clock')
            <circle cx="12" cy="12" r="8.5" /><path d="M12 7.5V12l3 2" />
            @break
        @case('list')
            <path d="M8 6h13M8 12h13M8 18h13" /><path d="M3.5 6h.01M3.5 12h.01M3.5 18h.01" />
            @break
        @case('settings')
            <circle cx="12" cy="12" r="3" /><path d="M19.4 15a1.7 1.7 0 0 0 .3 1.8l.1.1a2 2 0 1 1-2.8 2.8l-.1-.1a1.7 1.7 0 0 0-1.8-.3 1.7 1.7 0 0 0-1 1.5V21a2 2 0 1 1-4 0v-.1a1.7 1.7 0 0 0-1.1-1.5 1.7 1.7 0 0 0-1.8.3l-.1.1a2 2 0 1 1-2.8-2.8l.1-.1a1.7 1.7 0 0 0 .3-1.8 1.7 1.7 0 0 0-1.5-1H3a2 2 0 1 1 0-4h.1a1.7 1.7 0 0 0 1.5-1.1 1.7 1.7 0 0 0-.3-1.8l-.1-.1a2 2 0 1 1 2.8-2.8l.1.1a1.7 1.7 0 0 0 1.8.3H9a1.7 1.7 0 0 0 1-1.5V3a2 2 0 1 1 4 0v.1a1.7 1.7 0 0 0 1 1.5 1.7 1.7 0 0 0 1.8-.3l.1-.1a2 2 0 1 1 2.8 2.8l-.1.1a1.7 1.7 0 0 0-.3 1.8V9a1.7 1.7 0 0 0 1.5 1H21a2 2 0 1 1 0 4h-.1a1.7 1.7 0 0 0-1.5 1z" />
            @break
        @case('logout')
            <path d="M9 4H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h4" /><path d="M16 17l5-5-5-5" /><path d="M21 12H9" />
            @break
        @case('edit')
            <path d="M4 20h4L19 9l-4-4L4 16v4z" /><path d="M13.5 6.5l4 4" />
            @break
        @case('chevron')
            <path d="M9 5l7 7-7 7" />
            @break
        @case('bolt')
            <path d="M13 3L5 13h6l-1 8 8-10h-6z" />
            @break
    @endswitch
</svg>

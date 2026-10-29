<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#101226">
    <title>@yield('title', 'Jimpitan RT') · Jimpitan RT</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-dvh bg-ink-950 font-sans text-snow antialiased">
    <div class="relative mx-auto flex min-h-dvh w-full max-w-md flex-col overflow-hidden bg-ink-950 sm:border-x sm:border-edge">
        {{-- Cahaya warna di latar --}}
        <div aria-hidden="true" class="pointer-events-none absolute -right-20 -top-24 size-80 rounded-full bg-[radial-gradient(circle,rgba(255,107,90,.45),transparent_70%)]"></div>
        <div aria-hidden="true" class="pointer-events-none absolute -left-28 top-48 size-72 rounded-full bg-[radial-gradient(circle,rgba(139,124,255,.38),transparent_70%)]"></div>

        <main class="relative flex-1 space-y-4 px-5 pt-6 @hasSection('tanpa-nav') pb-8 @else pb-32 @endif">
            @include('partials.flash')
            @yield('content')
        </main>

        @hasSection('tanpa-nav')
        @else
            <x-bottom-nav />
        @endif
    </div>
</body>
</html>

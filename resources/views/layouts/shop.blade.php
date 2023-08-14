@props(['title' => config('app.name', 'Laravel')])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased selection:bg-black selection:text-white">

    <div x-data="{ open: false }" @keydown.window.escape="open = false" class="min-h-screen flex flex-col justify-between">
        <div class="flex-1">
            @include('includes.header')

            <main {{ $attributes->merge(['class' => 'z-0 h-full']) }}>
                {{ $slot }}
            </main>
        </div>

        @include('includes.footer')
    </div>

</body>
</html>

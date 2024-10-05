<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <x-shopper::favicons />
    @include('includes._analytics')

    <title>{{ $title ?? 'ShopStation' }} // {{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />

    @filamentStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased selection:bg-primary-300 selection:text-white">
    {{ $slot }}

    @livewire(\Filament\Notifications\Livewire\Notifications::class)
    @livewire(\Laravelcm\LivewireSlideOvers\SlideOverPanel::class)

    @filamentScripts
</body>
</html>

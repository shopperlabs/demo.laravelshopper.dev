<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <x-shopper::favicons />

        <title>{{ $title ?? 'ShopStation' }} // {{ config('app.name') }}</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net" />
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>

        @filamentStyles
        @vite('resources/css/app.css')
    </head>
    <body class="antialiased selection:bg-primary-800 selection:text-white">
        {{ $slot }}

        @livewire('notifications')
        @livewire('slide-over-panel')

        @filamentScripts
        @vite('resources/js/app.js')
    </body>
</html>

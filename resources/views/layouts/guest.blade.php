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
<body class="font-sans antialiased">
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6">
        <div class="py-2 flex items-center justify-between">
            <div class="flex-shrink-0">
                <a href="{{ route('home') }}" class="flex items-center space-x-3">
                    <x-brand class="h-12 text-black"/>
                </a>
            </div>
            <div class="inline-flex items-center text-base leading-6 text-secondary-500">
                <span>{{ __('Do you need us? Call us') }}</span>
                <a class="ml-4 inline-flex items-center font-heading font-semibold text-secondary-900 hover:text-black hover:underline" href="tel:{{ shopper_setting('shop_phone_number') }}">
                    <x-untitledui-phone class="w-5 h-5 mr-2 text-secondary-700" />
                    {{ shopper_setting('shop_phone_number') }}
                </a>
            </div>
        </div>

        <main>
            {{ $slot }}
        </main>
    </div>
</body>
</html>

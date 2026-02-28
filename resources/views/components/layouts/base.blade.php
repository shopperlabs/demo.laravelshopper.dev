@props([
    'title' => null,
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <x-shopper::favicons />
    @include('includes._analytics')

    <title>{{ $title ?? 'ShopStation' }} // {{ config('app.name') }}</title>

    <meta name="description" content="ShopStation — A demo storefront powered by Shopper. Explore products, collections, and a full checkout experience built with Livewire and Tailwind CSS." />
    <meta name="robots" content="index, follow" />
    <link rel="canonical" href="{{ url()->current() }}" />

    <!-- Open Graph -->
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{ $title ?? 'ShopStation' }} // {{ config('app.name') }}" />
    <meta property="og:description" content="ShopStation — A demo storefront powered by Shopper. Explore products, collections, and a full checkout experience built with Livewire and Tailwind CSS." />
    <meta property="og:image" content="https://docs.laravelshopper.dev/images/demo-store.jpg" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:site_name" content="{{ config('app.name') }}" />

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ $title ?? 'ShopStation' }} // {{ config('app.name') }}" />
    <meta name="twitter:description" content="ShopStation — A demo storefront powered by Shopper. Explore products, collections, and a full checkout experience built with Livewire and Tailwind CSS." />
    <meta name="twitter:image" content="https://docs.laravelshopper.dev/images/demo-store.jpg" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,800,900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased selection:bg-primary-50 selection:text-primary-600">
    {{ $slot }}

    <x-notification />

    @livewire(\Laravelcm\LivewireSlideOvers\SlideOverPanel::class)

    @fluxScripts
</body>
</html>

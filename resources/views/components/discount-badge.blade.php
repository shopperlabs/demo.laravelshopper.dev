@props(['discount'])

<span {{ $attributes->twMerge(['class' => 'inline-flex items-center bg-pink-50 px-2 py-1 text-xs font-medium text-pink-700 ring-1 ring-inset ring-pink-600/10']) }}>
    {{ __('-:discount%', ['discount' => $discount]) }}
</span>

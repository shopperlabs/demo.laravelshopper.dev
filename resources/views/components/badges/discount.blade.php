@props(['discount'])

<span {{ $attributes->merge(['class' => 'inline-flex items-center rounded-lg bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10']) }}>
    {{ __('-:discount%', ['discount' => $discount]) }}
</span>

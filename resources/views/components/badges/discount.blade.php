@props(['discount'])

<span {{ $attributes->merge(['class' => 'inline-flex items-center rounded-md bg-primary-50 px-1.5 py-0.5 text-xs font-medium text-primary-700 ring-1 ring-inset ring-primary-600/10']) }}>
    {{ __('-:discount%', ['discount' => $discount]) }}
</span>

@props([
    'title',
    'variant',
])

@php
    $dotClass = match ($variant) {
        'info' => 'bg-blue-500',
        'teal' => 'bg-teal-500',
        'success' => 'bg-green-500',
        'danger' => 'bg-rose-500',
        'warning' => 'bg-yellow-500',
        'primary' => 'bg-violet-500',
        'sky' => 'bg-sky-500',
        'indigo' => 'bg-indigo-500',
        'orange' => 'bg-orange-500',
        default => 'bg-zinc-400',
    };
@endphp

<div {{ $attributes->twMerge(['class' => 'inline-flex items-center gap-2 bg-white rounded-full px-2 py-1 text-xs font-medium text-zinc-600 ring-1 ring-inset ring-zinc-200']) }}>
    <div @class([
        'size-1.5 self-center rounded-full',
        $dotClass
    ])></div>
    <span>{{ $title }}</span>
</div>

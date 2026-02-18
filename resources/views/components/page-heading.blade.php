@props([
    'title',
    'description' => null,
])

<div>
    <h2 class="font-heading text-2xl font-semibold text-zinc-900">
        {{ $title }}
    </h2>
    @if ($description)
        <p class="mt-1 text-sm text-zinc-500">{{ $description }}</p>
    @endif
</div>

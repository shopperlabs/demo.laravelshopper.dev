@props([
    'rounded' => 'rounded-md',
    'strokeWidth' => 2,
    'strokeColor' => 'text-zinc-300',
])

<span {{ $attributes->class(['pointer-events-none absolute inset-0 flex items-center justify-center', $rounded]) }}>
    <svg class="size-full {{ $strokeColor }}" viewBox="0 0 100 100" preserveAspectRatio="none" stroke="currentColor">
        <line x1="0" y1="100" x2="100" y2="0" stroke-width="{{ $strokeWidth }}" vector-effect="non-scaling-stroke" />
    </svg>
</span>

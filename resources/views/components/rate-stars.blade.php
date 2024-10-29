@props(['rating' => 0])

<div class="flex items-center">
    @foreach ([1, 2, 3, 4, 5] as $star)
        {{-- format-ignore-start --}}
        <x-heroicon-s-star
            @class([
                'size-5 shrink-0',
                'text-yellow-400' => $rating >= $star,
                'text-gray-200' => $rating < $star,
            ])
            aria-hidden="true"
        />
        {{-- format-ignore-end --}}
    @endforeach
</div>

@props([
    'items' => false,
    'key' => 'id',
    'value' => 'name'
])

<select {!! $attributes->merge(['class' => 'block w-full px-3 rounded-lg border border-gray-200 bg-white focus:outline-none focus:border-transparent focus:ring-2 focus:ring-primary-500 sm:text-sm']) !!}>
    @if($items)
        @foreach($items as $item)
            <option value="{{ $item->{$key} }}">{{ $item->{$value} }}</option>
        @endforeach
    @else
        {{ $slot }}
    @endif
</select>

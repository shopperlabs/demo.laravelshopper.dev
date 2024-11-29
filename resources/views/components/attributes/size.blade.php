@props(['attribute'])

<div wire:key="{{ $attribute->id }}" x-data="{ selectedAttributes: @entangle('selectedAttributes') }" class="py-6">
    <p class="block text-sm font-medium text-gray-900">{{ $attribute->name }}</p>
    @if ($attribute->values->isNotEmpty())
        <div class="grid grid-cols-3 gap-3 sm:grid-cols-5 mt-6">
            @foreach ($attribute->values as $value)
                <label
                    class="flex items-center justify-center px-3 py-3 text-sm font-medium uppercase border cursor-pointer focus:outline-none sm:flex-1"
                    :class="selectedAttributes.includes('{{ $value->id }}') ? 'border-transparent bg-primary-600 text-white hover:bg-primary-700' : 'border-gray-200 bg-white text-gray-900 hover:bg-gray-50'">
                    <input id="{{ $attribute->slug }}-{{ $value->id }}"
                        wire:model.live.debounce.350ms="selectedAttributes"
                        type="checkbox"
                        class="sr-only"
                        value="{{ $value->id }}"
                        wire:model.live.debounce.350ms="selectedAttributes"
                        :checked="selectedAttributes.includes('{{ $value->id }}')"
                    />
                    <span>{{ $value->value }}</span>
                </label>
            @endforeach
        </div>
    @endif
</div>

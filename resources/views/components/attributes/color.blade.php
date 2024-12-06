@props(['attribute'])

<div wire:key="{{ $attribute->id }}" x-data="{ selectedColorAttributes: @entangle('selectedAttributes') }" class="py-6">
    <p class="block text-sm font-medium text-gray-900">{{ $attribute->name }}</p>

    @if ($attribute->values->isNotEmpty())
        <div class="grid grid-cols-3 gap-3 sm:grid-cols-6 mt-6">
            @foreach ($attribute->values as $index => $value)
                <div class="flex items-center space-x-4" wire:key="{{ $attribute->slug }}-{{ $value->key }}">
                    <label
                        class="relative -m-0.5 flex cursor-pointer items-center justify-center rounded p-0.5"
                    >
                        <input id="{{ $attribute->slug }}-{{ $value->id }}"
                               wire:model.live.debounce.350ms="selectedAttributes"
                               type="checkbox"
                               class="sr-only"
                               value="{{ $value->id }}"
                               wire:model.live.debounce.350ms="selectedAttributes"
                               :checked="selectedColorAttributes.includes('{{ $value->id }}')"
                        />
                        <span
                            aria-hidden="true"
                            style="background-color: {{ $value->key }} "
                            class="h-8 w-8 rounded-full "
                            :class="selectedColorAttributes.includes('{{ $value->id }}') ? 'ring-2 ring-primary-600 ring-offset-2' : 'border-double border-2 border-black border-opacity-10 ' "
                        ></span>
                    </label>
                </div>
            @endforeach
        </div>
    @endif
</div>

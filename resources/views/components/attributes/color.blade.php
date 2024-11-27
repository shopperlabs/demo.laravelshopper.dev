@props(['attribute' => null])

<fieldset wire:key="{{ $attribute->id }}" x-data="{ selectedColorAttributes: @entangle('selectedAttributes') }">
    <legend class="block text-sm font-medium text-gray-900">{{ $attribute->name }}</legend>

    @if ($attribute->values->isNotEmpty())
        <div class="grid grid-cols-3 gap-3 sm:grid-cols-6 pt-6">
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
                            :class="selectedColorAttributes.includes('{{ $value->id }}') ? ' border-double border-2 border-primary-600' : 'border-double border-2 border-black border-opacity-10 ' "
                        ></span>
                    </label>
                </div>
            @endforeach
        </div>
    @endif
</fieldset>

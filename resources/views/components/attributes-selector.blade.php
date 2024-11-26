@props(['attribute'])


@if($attribute->slug === "size")
    <x-attributes.size :attribute="$attribute"/>
@elseif($attribute->slug === "color")
    <x-attributes.color :attribute="$attribute"/>
@else
    <fieldset wire:key="{{ $attribute->id }}">
        <legend class="block text-sm font-medium text-gray-900">{{ $attribute->name }}</legend>
        @if ($attribute->values->isNotEmpty())
            <div class="space-y-3 pt-6">
                @foreach ($attribute->values as $index => $value)
                    <div class="flex items-center" wire:key="{{ $attribute->slug }}-{{ $value->key }}">
                        <input id="{{ $attribute->slug }}-{{ $index }}"
                               wire:model.live.debounce.350ms="selectedAttributes"
                               value="{{ $value->id }}"
                               type="checkbox"
                               class="size-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <label for="{{ $attribute->slug }}-{{ $index }}" class="ml-3 text-sm text-gray-600">{{ $value->value }}</label>
                    </div>
                @endforeach
            </div>
        @endif
    </fieldset>
@endif


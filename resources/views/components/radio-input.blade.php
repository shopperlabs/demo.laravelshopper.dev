<input type="radio" {!! $attributes->merge([
    'class' => 'mt-1 transition duration-75 bg-white border-none shadow-sm fi-radio-input ring-1 checked:ring-0 focus:ring-2 focus:ring-offset-0 disabled:bg-gray-50 disabled:text-gray-50 disabled:checked:bg-current disabled:checked:text-gray-400
     text-primary-600 ring-gray-950/10 focus:ring-primary-600 checked:focus:ring-primary-500/50',
]) !!}  wire:loading.attr="disabled" >

@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'inline-flex w-full shadow-sm placeholder-secondary-500 shadow-sm focus:ring-black focus:ring-2 focus:border-secondary-500 border-secondary-300 focus:border-transparent focus:outline-none sm:text-sm']) !!} />

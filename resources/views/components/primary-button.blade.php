<button {{ $attributes->merge(['class' => 'inline-flex items-center px-4 py-2 bg-primary-500 rounded-md text-white hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-900 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-200']) }}>
    {{ $slot }}
</button>

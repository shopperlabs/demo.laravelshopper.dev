@props([
    'formAction' => false,
    'headerClasses' => '',
    'contentClasses' => 'p-4 sm:p-6',
    'footerClasses' => 'p-4 sm:flex sm:p-6',
])

<div {{ $attributes->twMerge(['class' => 'h-full bg-white z-50']) }}>
    @if ($formAction)
        {{-- format-ignore-start --}}<form wire:submit="{{ $formAction }}">{{-- format-ignore-end --}}
            @endif

            <div class="flex flex-col h-full">
                <div class="flex-1 h-0 overflow-y-auto">
                    <div class="{{ $headerClasses }}">
                        @if (isset($title))
                            <h3
                                class="flex items-center text-lg font-semibold leading-6 text-gray-900 font-heading lg:text-xl"
                            >
                                {{ $title }}
                            </h3>
                        @endif

                        @if (isset($subtitle))
                            <div class="mt-2">
                                <p class="text-sm leading-5 text-gray-500">
                                    {{ $subtitle }}
                                </p>
                            </div>
                        @endif
                    </div>

                    <div class="{{ $contentClasses }}">
                        {{ $slot }}
                    </div>
                </div>
                <div class="{{ $footerClasses }}">
                    {{ $buttons ?? null }}
                </div>
            </div>

            @if ($formAction)
                {{-- format-ignore-start --}}</form>{{-- format-ignore-end --}}
    @endif
</div>

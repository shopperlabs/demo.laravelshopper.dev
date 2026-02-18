<div x-data="{
        shown: false,
        timeout: null,
        title: '',
        message: '',
        type: 'success',
        show(data) {
            this.title = data.title ?? '';
            this.message = data.message ?? '';
            this.type = data.type ?? 'success';
            clearTimeout(this.timeout);
            this.shown = true;
            this.timeout = setTimeout(() => { this.shown = false }, 3000);
        },
        get iconColor() {
            return {
                success: 'text-green-400',
                error: 'text-red-400',
                warning: 'text-yellow-400',
                info: 'text-blue-400',
            }[this.type] ?? 'text-green-400';
        }
     }"
     @notify.window="show($event.detail)"
     x-show="shown"
     x-transition:enter="transform ease-out duration-300 transition"
     x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
     x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
     x-transition:leave="transition ease-in duration-100"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     style="display: none;"
     class="pointer-events-none fixed inset-0 z-50 flex items-end px-4 py-6 sm:items-start sm:p-6"
>
    <div class="flex w-full flex-col items-center space-y-4 sm:items-end">
        <div class="pointer-events-auto w-full max-w-sm overflow-hidden rounded-lg bg-white shadow-lg ring-1 ring-black/5">
            <div class="p-4">
                <div class="flex items-start">
                    <div class="shrink-0">
                        {{-- Success --}}
                        <svg x-show="type === 'success'" :class="iconColor" class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z" />
                        </svg>
                        {{-- Error --}}
                        <svg x-show="type === 'error'" :class="iconColor" class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z" />
                        </svg>
                        {{-- Warning --}}
                        <svg x-show="type === 'warning'" :class="iconColor" class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                        {{-- Info --}}
                        <svg x-show="type === 'info'" :class="iconColor" class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0zm-9-3.75h.008v.008H12V8.25z" />
                        </svg>
                    </div>
                    <div class="ml-3 w-0 flex-1 pt-0.5">
                        <p x-show="title" x-text="title" class="text-sm font-medium text-gray-900"></p>
                        <p x-show="message" x-text="message" class="mt-1 text-sm text-gray-500"></p>
                    </div>
                    <div class="ml-4 flex shrink-0">
                        <button type="button" @click="shown = false" class="inline-flex rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                            <span class="sr-only">{{ __('Close') }}</span>
                            <x-untitledui-x class="size-5" />
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

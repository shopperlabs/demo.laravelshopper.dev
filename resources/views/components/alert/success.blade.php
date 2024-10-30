@props(['status'])

@if (session('status'))
    <div {{ $attributes->merge(['class' => 'bg-success-50 p-4']) }}>
        <div class="flex">
            <div class="shrink-0">
                <svg class="h-5 w-5 text-success-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-success-800">
                    {{ $status }}
                </p>
            </div>
        </div>
    </div>
@endif

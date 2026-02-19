<div class="pb-16 sm:pb-24">
    <div class="py-3 bg-white/80 border-b border-zinc-200">
        <x-container>
            {{ Breadcrumbs::render('blog.show', $post) }}
        </x-container>
    </div>
    <x-container class="pb-24 pt-10">
        <div class="mx-auto max-w-3xl">

            <div class="flex items-center gap-x-3 text-sm text-zinc-500">
                <time datetime="{{ $post->published_at->toDateString() }}">
                    {{ $post->published_at->translatedFormat('F d, Y') }}
                </time>
                @if ($post->category)
                    <span class="text-zinc-300">&middot;</span>
                    <span class="inline-flex items-center rounded-full bg-zinc-100 px-2.5 py-0.5 text-xs font-medium text-zinc-600">
                        {{ $post->category->name }}
                    </span>
                @endif
            </div>

            <h1 class="mt-4 text-3xl font-bold tracking-tight text-zinc-900 font-heading sm:text-4xl">
                {{ $post->title }}
            </h1>

            @if ($post->excerpt)
                <p class="mt-4 text-lg text-zinc-500">
                    {{ $post->excerpt }}
                </p>
            @endif

            <div class="mt-4 flex items-center gap-x-3">
                <p class="text-sm font-medium text-zinc-900">
                    {{ __('By :name', ['name' => $post->author->full_name]) }}
                </p>
            </div>

            @if ($post->getFirstMediaUrl('image'))
                <div class="mt-8 overflow-hidden rounded-2xl">
                    <img
                        src="{{ $post->getFirstMediaUrl('image') }}"
                        alt="{{ $post->title }}"
                        class="w-full object-cover"
                    />
                </div>
            @endif

            <div class="prose prose-zinc mt-10 max-w-none prose-headings:font-heading prose-a:text-primary-600 prose-img:rounded-xl">
                {!! clean($post->content) !!}
            </div>
        </div>
    </x-container>
</div>

<div class="pb-16 sm:pb-24">
    <div class="py-3 bg-white/80 border-b border-zinc-200">
        <x-container>
            {{ Breadcrumbs::render('blog') }}
        </x-container>
    </div>
    <x-container class="pb-24 pt-10">
        <div>
            <h1 class="text-4xl font-semibold tracking-tight text-pretty text-zinc-900 font-heading sm:text-5xl">{{ __('Blog') }}</h1>
            <p class="mt-2 text-lg/8 text-zinc-500">
                {{ __('Insights, guides, and stories from our team.') }}
            </p>

            @if ($posts->isNotEmpty())
                <div wire:loading.class="opacity-50 pointer-events-none" class="mt-10 border-t border-zinc-200 pt-10 transition-opacity sm:mt-16 sm:pt-16">
                    <div class="grid grid-cols-1 gap-x-8 gap-y-16 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($posts as $post)
                            <article wire:key="post-{{ $post->id }}" class="flex max-w-xl flex-col items-start justify-between">
                                <div class="flex items-center gap-x-4 text-xs">
                                    <time datetime="{{ $post->published_at->toDateString() }}" class="text-zinc-500">
                                        {{ $post->published_at->translatedFormat('M d, Y') }}
                                    </time>
                                    @if ($post->category)
                                        <span class="relative z-10 rounded-full bg-zinc-50 px-3 py-1.5 font-medium text-zinc-600 hover:bg-zinc-100">
                                            {{ $post->category->name }}
                                        </span>
                                    @endif
                                </div>
                                <div class="group relative">
                                    <h2 class="mt-3 text-lg/6 font-semibold text-zinc-900 group-hover:text-zinc-600">
                                        <a href="{{ route('blog.show', $post) }}" wire:navigate>
                                            <span class="absolute inset-0"></span>
                                            {{ $post->title }}
                                        </a>
                                    </h2>
                                    @if ($post->excerpt)
                                        <p class="mt-5 line-clamp-3 text-sm/6 text-zinc-600">
                                            {{ $post->excerpt }}
                                        </p>
                                    @endif
                                </div>
                                <div class="relative mt-8 flex items-center gap-x-4">
                                    <div class="text-sm/6">
                                        <p class="font-semibold text-zinc-900">
                                            {{ $post->author->full_name }}
                                        </p>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>

                <div class="mt-10">
                    {{ $posts->links() }}
                </div>
            @else
                <p class="mt-10 text-center text-zinc-500">{{ __('No posts yet. Check back soon!') }}</p>
            @endif
        </div>
    </x-container>
</div>

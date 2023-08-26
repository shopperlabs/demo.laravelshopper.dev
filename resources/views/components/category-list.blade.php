<div class="py-16 lg:pt-20">
    <ul role="list" class="grid gap-y-10 sm:grid-cols-2 sm:gap-x-8 lg:grid-cols-4 lg:gap-x-12">
        @foreach($categories->toTree() as $category)
            <li>
                <div class="aspect-w-2 aspect-h-1 rounded-xl shadow-lg overflow-hidden">
                    <img class="object-cover h-full w-full" src="{{ $category->getFirstMediaUrl(config('shopper.core.storage.collection_name')) }}" alt="{{ $category->name }}" />
                </div>
                <div class="mt-5 px-4">
                    <h3 class="text-base text-secondary-900 font-medium hover:text-black transition ease-in leading-6">
                        <a href="#" class="inline-flex items-center">
                            {{ $category->name }}
                            <x-untitledui-arrow-narrow-right class="h-5 w-5 ml-2" />
                        </a>
                    </h3>
                    <nav role="navigation" class="mt-3 flex flex-col">
                        @foreach($category->children->take(6) as $child)
                            <a href="#" class="inline-flex text-sm leading-5 inline-flex py-1.5 text-secondary-500 hover:text-secondary-900 transition ease-in">
                                {{ $child->name }}
                            </a>
                        @endforeach
                        @if($category->children->count() > 6)
                            <a href="#" class="mt-4 text-sm font-medium text-secondary-700 hover:text-secondary-900 group group-link-underline">
                                <span class="inline-flex items-center link link-underline link-underline-black">
                                    <x-untitledui-plus class="h-4 w-4 mr-1" />
                                    {{ __('View All') }}
                                </span>
                            </a>
                        @endif
                    </nav>
                </div>
            </li>
        @endforeach
    </ul>
</div>

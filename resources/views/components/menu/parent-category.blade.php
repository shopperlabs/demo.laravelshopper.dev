<div class="flex justify-center space-x-3 -mx-3">
    @foreach($categories as $category)
        <x-menu-link :title="$category->name" href="#" />
    @endforeach
</div>

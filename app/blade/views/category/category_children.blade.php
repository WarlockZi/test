<div class="category-child-wrap">
    @foreach ($category->childrenRecursive as $child)
        @include('category.category_card', compact('child'))
    @endforeach
</div>
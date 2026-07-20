<div class="category-child-wrap">
    @foreach ($category['children_recursive'] as $child)
        @include('category.category_card', compact('child'))
    @endforeach
</div>
<ul class="h-cat_submenu level-{!! $level !!}">
    @php ++$level; @endphp

    @php $children = $child['children_recursive']??[] @endphp

    @if(!empty($children))

            @foreach($children as $child)
                @include('layouts.main.header.blueRibbon.headerCategoryMenu.li', compact('level', 'child'))
            @endforeach
    @else
        @include('layouts.main.header.blueRibbon.headerCategoryMenu.li', compact('level', 'child'))
    @endif

</ul>
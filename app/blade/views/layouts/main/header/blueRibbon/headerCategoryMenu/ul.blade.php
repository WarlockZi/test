<ul class="h-cat_submenu level-{!! $level !!}">
    @php ++$level; @endphp
    @if(!empty($child['children']))
            @foreach($child['children'] as $child)
                @include('layouts.main.header.blueRibbon.headerCategoryMenu.li', compact('level', 'child'))
            @endforeach
    @else
        @include('layouts.main.header.blueRibbon.headerCategoryMenu.li', compact('level', 'child'))
    @endif

</ul>
<ul class="h-cat_submenu level-{!!$level!!}">
    @php ++$level; @endphp
    @if(!empty($child['children_recursive']))
        @foreach($child['children_recursive'] as $child)
            @php($href = "/catalog/{$child['own_properties']['path']}")
{{--        @deb--}}
            @include('layouts.main.header.blueRibbon.headerCategoryMenu.li', compact('level', 'child','href'))
        @endforeach
    @else
        @php($href = "/catalog/{$child['own_properties']['path']}")
        @include('layouts.main.header.blueRibbon.headerCategoryMenu.li', compact('level', 'child','href'))
    @endif

</ul>
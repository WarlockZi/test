<ul class="h-cat_submenu level-{!!$level!!}">
    @php ++$level; @endphp
    @if(count($child['children']))
        @foreach($child['children'] as $child)
            @php($path = $child['own_properties']['path']??'')
            @php($href = "/catalog/{$path}")
            @include('layouts.main.header.blueRibbon.headerCategoryMenu.li', compact('level', 'child','href'))
        @endforeach
    @else
        @php($path = $child['own_properties']['path']??'')
        @php($href = "/catalog/{$path}")
        @include('layouts.main.header.blueRibbon.headerCategoryMenu.li', compact('level', 'child','href'))
    @endif

</ul>
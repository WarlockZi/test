<li class="h-cat_item">

{{--    @deb--}}
    @if(!empty($child['children_recursive']))
        <div class="wrap">

            <a href="/catalog/{{$child['own_properties']['path']}}">{{$child['name']}}</a>
            <span class="arrow">></span>
        </div>
        @include('layouts.main.header.blueRibbon.headerCategoryMenu.ul', compact('child'))
    @else
        <a href="/catalog/{{$child['own_properties']['path']}}">{{$child['name']}}</a>
    @endif

</li>
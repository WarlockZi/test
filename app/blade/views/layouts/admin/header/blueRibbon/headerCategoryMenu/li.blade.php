<li class="h-cat_item">

    @php $children = $child['children_recursive'] @endphp
    @if(!empty($children))
        <div class="wrap">
            <a href="{{$child['href']}}">{{$child['name']}}</a>
            <span class="arrow">></span>
        </div>
        @include('layouts.main.header.blueRibbon.headerCategoryMenu.ul', compact('child'))
    @else
        <a href="{{$child['href']}}">{{$child['name']}}</a>
    @endif

</li>
<li class="h-cat_item">

{{--    @deb--}}
    @if(!empty($child['children_recursive']))
        <div class="wrap">

            <a href="{{$href}}">{{$child['name']}}</a>
            <span class="arrow">></span>
        </div>
        @include('layouts.main.header.blueRibbon.headerCategoryMenu.ul', compact('child'))
    @else
        <a href={{$href}}>{{$child['name']}}</a>
    @endif

</li>
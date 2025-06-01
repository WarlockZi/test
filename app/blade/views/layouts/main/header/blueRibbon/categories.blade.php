@php     $level = 1; @endphp
@foreach (APP->get('rootCategories') as $rootCategory)

    <div class='h-cat'>
        {{$rootCategory['name']}}
        <a href="{{$rootCategory['href']}}" class='show-front-a'></a>


        <ul class="h-cat_submenu level-{!! $level !!}">

            @php $children =  $rootCategory['children_recursive'] ?? [];@endphp
            @if(!empty($children))
                @foreach($children as $child)
                    @include('layouts.main.header.blueRibbon.headerCategoryMenu.li',compact('child','level'))
                @endforeach
            @endif

        </ul>
    </div>
@endforeach

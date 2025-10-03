@php
    $level = 1;
    $rootCategories = APP->get('rootCategories');
@endphp

@if($rootCategories)
    @foreach ($rootCategories as $rootCategory)

        <div class='h-cat'>
            {{$rootCategory['name']}}
            <a href="{{$rootCategory['own_properties']['path']}}" class='show-front-a'></a>

            <ul class="h-cat_submenu level-{!! $level !!}">


                @if(!empty($rootCategory['children_recursive']))
                    @foreach($rootCategory['children_recursive'] as $child)
                        {{--                    @php(xdebug_break())--}}
                        @include('layouts.main.header.blueRibbon.headerCategoryMenu.li',compact('child','level'))
                    @endforeach
                @endif

            </ul>
        </div>
    @endforeach
@endif

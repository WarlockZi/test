@deb
@php
    $level = 1;
    $rootCategories = APP->get('rootCategoriesOrderedByName')->toArray();
@endphp
@if($rootCategories)
    @foreach ($rootCategories as $rootCategory)

        <div class='h-cat'>{{$rootCategory['name']}}
            <a href="/catalog/{{$rootCategory['own_properties']['path']}}"
               class='show-front-a'></a>

            <ul class="h-cat_submenu level-{!!$level!!}">

                @if(!empty($rootCategory['children']))
                    @foreach($rootCategory['children'] as $child)
                        @php($href = "/catalog/{$child['own_properties']['path']}")
                        @include('layouts.main.header.blueRibbon.headerCategoryMenu.li',compact('child','level','href'))
                    @endforeach
                @endif

            </ul>
        </div>
    @endforeach
@endif

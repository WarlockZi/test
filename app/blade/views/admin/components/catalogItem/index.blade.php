{{--@php xdebug_break() @endphp--}}
@if($catItem['pageTitle'])
    <div class='page-name'>{!! $catItem['pageTitle']!!}</div>
@endif

<div class="item-wrap"
     data-model="{!! $catItem['model'] !!}"
     data-id="{!! $catItem['item']['id'] !!}"
>

    @if($catItem['tabs'])
        @include('admin.components.catalogItem.withTabs')
    @else
        @include('admin.components.catalogItem.noTabs')
    @endif
</div>

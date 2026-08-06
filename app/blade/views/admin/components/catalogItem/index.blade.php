<div class='page-name'>{!!$catItem['pageTitle']??''!!}</div>


<div class="item-wrap"
     {!!$catItem['dataAttributes']??''!!}
     data-model="{!!$catItem['model']??''!!}"
     data-id="{!!data_get($catItem, 'item.id')!!}"
>
    {{--@deb--}}
    @if($catItem['tabs'])
        @include('admin.components.catalogItem.withTabs')
    @else
        @include('admin.components.catalogItem.noTabs')
    @endif
</div>

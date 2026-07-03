<div
        data-row
        data-id='{!!$item['id']??"0"!!}'
        {!!$c->class??""!!}
        {!!$c->dataAttributes??""!!}
        {!!$c->contenteditable??""!!}
>

    @if(is_callable($c->callbackFn))
        @php($fn = $c->callbackFn)
        {!!$fn($item)!!}
    @else
{{--    @deb--}}
        {!!$c->getData($c, $item, $field)??''!!}
    @endif
</div>

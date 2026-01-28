@php
    use app\view\components\Builders\CheckboxBuilder\Checkbox\ICheckbox;
@endphp

<div
        data-row
        data-id='{!!$item['id']??"0"!!}'
        {!!$c->dataAttributes??""!!}
        {!!$c->class??""!!}
        {!!$c->contenteditable??""!!}
>

    @if($c->component instanceof ICheckbox)
        @include('admin.components.checkbox.checkbox', ['checkbox'=>$c->component, 'item'=>$item] )
    @elseif(is_callable($c->callbackFn))
        {{--        @deb--}}
        @php($fn = $c->callbackFn)
        {!!$fn($item)!!}
    @else
        {!!$c->getData($c, $item, $field)!!}
    @endif
</div>

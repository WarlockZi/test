@php
    use app\view\components\Builders\CheckboxBuilder\Checkbox\ICheckbox;
@endphp

@if ($c->html)
        <?= $c->html ?>
@else
    <div
            data-id='<?= $item['id'] ?? 0; ?>'
            <?= $c->dataField; ?>
        <?= $c->pivot; ?>
        <?= $c->attach; ?>
        <?= $c->class; ?>
        <?= $c->contenteditable; ?>
    >
        {{--                            @php xdebug_break() @endphp--}}
        @if($c->component instanceof ICheckbox)
            @include('admin.components.checkbox.checkbox', ['checkbox'=>$c->component, 'item'=>$item] )
        @else
{{--@php(xdebug_break())--}}
            {!!  $c->getData($c, $item, $field) !!}
        @endif
    </div>
@endif
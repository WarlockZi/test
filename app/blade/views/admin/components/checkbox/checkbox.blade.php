@if(!empty($checkbox->label))
    <label
            <?= $checkbox->labelClass; ?>
        <?= $checkbox->for; ?>
    >
            <?= $checkbox->label; ?>
    </label>

@endif

<input
        my-checkbox
        type="checkbox"

        {!!  $checkbox->execCheckedFn($item) !!}

{{--@php xdebug_break(); @endphp--}}
        @foreach( $checkbox->dataField as $field)
            data-field='{!! $field !!}'
        @endforeach

        @foreach($checkbox->dataPivotField as $field)
            data-pivot='{!! $field !!}'
        @endforeach
        @foreach( $checkbox->data as $key=>$value)
{{--@php xdebug_break(); @endphp--}}
            data-{!! $key !!}='{!! $value!!}'
        @endforeach
    <?= $checkbox->class ?? ''; ?>
    <?= $checkbox->field ?? ''; ?>
    <?= $checkbox->pivot ?? ''; ?>
>
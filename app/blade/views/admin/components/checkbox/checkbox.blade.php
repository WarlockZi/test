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

        @if(method_exists($checkbox, 'execCheckedFn'))
            {!! $checkbox->execCheckedFn($item)!!}
        @else
            {!! $checkbox->checked!!}
        @endif

        @if(is_array($checkbox->data))
            {{--            @deb--}}
            @foreach($checkbox->data as $key=>$value)
                data-{!!$key!!}={!!$value!!}
        @endforeach
        @else

        {!!$checkbox->data!!}
        @endif
        @foreach( $checkbox->dataField as $field)
            data-field='{!!$field!!}'
        @endforeach

        @foreach($checkbox->dataPivotField as $field)
            data-pivot='{!!$field!!}'
        @endforeach

        {{--        @deb--}}
        {{--        @foreach( $checkbox->data as $key=>$value)--}}
        {{--            data-{!!$key!!}='{!!$value!!}'--}}
        {{--        @endforeach--}}
    <?= $checkbox->class ?? ''; ?>
    <?= $checkbox->field ?? ''; ?>
    <?= $checkbox->pivot ?? ''; ?>
>
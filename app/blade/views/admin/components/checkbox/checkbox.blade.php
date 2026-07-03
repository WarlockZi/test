@if(!empty($checkbox->label))
    <label
            {!!$checkbox->labelClass!!}
            {!!$checkbox->for!!}
    >
        {!!$checkbox->label!!}
    </label>

@endif
{{--@deb--}}
<input
        my-checkbox
        type="checkbox"
        {!!$checkbox->class ?? ''!!}
        {!!$checkbox->id ?? ''!!}
        {!!$checkbox->checked ?? false!!}
        {!!$checkbox->dataAttributes ?? ''!!}

>
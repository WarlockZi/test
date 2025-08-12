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

        {!!  $checkbox->checkedFn($item) !!}
        <?= $checkbox->data ?? ''; ?>
        @foreach( $checkbox->itemData as $index=>$field)
            @php $value = $checkbox->dataField($item,$index) @endphp
            data-{!! $field !!}={!! $value !!}
        @endforeach

        @foreach($checkbox->pivotData as $index=>$field)
            @php $value = $checkbox->dataPivotField($item,$index) @endphp
            data-pivot-{!! $field !!}={!! $value !!}
        @endforeach

    <?= $checkbox->class ?? ''; ?>
    <?= $checkbox->field ?? ''; ?>
    <?= $checkbox->pivot ?? ''; ?>
>
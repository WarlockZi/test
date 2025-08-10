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
        @php
            $checkedFFn               = $checkbox->checkedFFn;
        @endphp
        {!!  $checkedFFn($item)?'checked':'';!!}
        <?= $checkbox->data ?? ''; ?>
        @foreach( $checkbox->itemData as $index=>$field)
            @php $value = $checkbox->getItemData($item,$index) @endphp
            data-{!! $field !!}={!! $value !!}
        @endforeach

        @foreach($checkbox->pivotData as $index=>$field)
            @php $value = $checkbox->getItemData($item,$index) @endphp
            data-pivot-{!! $field !!}={!! $value !!}
        @endforeach

    <?= $checkbox->class ?? ''; ?>
    <?= $checkbox->field ?? ''; ?>
    <?= $checkbox->pivot ?? ''; ?>
>
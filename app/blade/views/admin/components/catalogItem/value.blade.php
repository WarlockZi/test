<div class="value">
    <div
        {!!$field->dataAttributes!!}
        {!!$field->contenteditable!!}
        {!!$field->required!!}
    >
        @if(isset($field->dnd))
            @include('admin.components.dnd.dnd')
        @elseif(isset($field->checkbox))
            @include('admin.components.checkbox.checkbox', ['checkbox'=>$field->checkbox])
        @else
            {!!$field->value!!}
        @endif
    </div>
</div>
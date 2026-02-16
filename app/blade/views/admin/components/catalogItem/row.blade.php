<div class="row" {{$field->hidden}}>
{{--        @deb--}}
    <div
            class="field"
            @if($field->tooltip)
                aria-label="{{$field->tooltip}}"
            role="tooltip"
            data-tip="{{$field->tooltip}}"
            @endif
    >{{$field->name}}</div>
    :
    @include('admin.components.catalogItem.value')
</div>

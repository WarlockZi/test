@if($data['addButton'])

{{--            @deb--}}
    @foreach ($data['columns'] as $field=>$c)
        <div
                hidden
                data-row
                data-id='0'
                {!!$c->dataAttributes??''!!}
                {!!$c->class??''!!}
                {!!$c->dataField??''!!}
                {!!$c->contenteditable??''!!}
        >
            {!!$c->emptyRow!!}
        </div>

    @endforeach

    @if($data['headEditCol'])
        <div hidden class='edit' data-id='0'></div>
    @endif
    @if($data['headDelCol'])
        <div hidden class='del' data-id='0'></div>
    @endif
@endif
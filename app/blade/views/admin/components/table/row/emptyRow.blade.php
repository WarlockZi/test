@if($data['addButton'])

    @foreach ($data['columns'] as $field=>$c)
        <div
                hidden
                data-row
                data-id='0'
                {!!$c->dataAttributes??''!!}
                {!!$c->class??''!!}
                {!!$c->contenteditable??''!!}
        >
            {!!$c->emptyRow!!}
        </div>

    @endforeach
    @if($data['headEditCol'])
        <div hidden class='edit' data-id='0'>{!!$c->name!!}</div>
    @endif
    @if($data['headDelCol'])
        <div hidden class='del' data-id='0'></div>
    @endif
@endif
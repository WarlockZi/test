{{--@deb--}}
@foreach ($data['columns'] as $c)
    <div
            {!!$c->headerClass??''!!}
            {!!$c->headerSort??''!!}
    >
        {!!$c->headerSortIcon??''!!}
        {!!$c->headerTitle??''!!}
        {!!$c->headerSearch??''!!}
    </div>
@endforeach
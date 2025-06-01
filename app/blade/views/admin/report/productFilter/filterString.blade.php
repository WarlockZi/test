<div class="filter">
    <div class='used-filters'>
{{--        @php xdebug_break(); @endphp--}}
        @foreach ($filterString->initialFilters as $name => $data)
            @if (array_key_exists($name, $filterString->notNull))
                <span class='selected-filter'>{!! $data['title']!!}
                <span class='selected-value'>{!! $data['options'][$filterString->notNull[$name]] !!}</span>
                </span>
            @else
                <span>{!! $data['title'] !!}<span>*</span></span>
            @endif
        @endforeach
    </div>
</div>
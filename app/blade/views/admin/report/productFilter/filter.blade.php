<div class="filter">
    <div class="title">{!! $filter->title ?? ''!!}</div>


    <select {!! $filter->name ?? ''!!} select-new>
        {!! $filter->emptyOption ?? '' !!}
        {{--        @php  xdebug_break();@endphp--}}
        @foreach ($filter->options as $key => $value)
            @if(key_exists($filter->filterName, $filter->toFilter))
                @php
                    $selected = ($key === (int)$filter->toFilter[$filter->filterName]
                && !empty($filter->toFilter[$filter->filterName]))
                ? 'selected': '';
                @endphp
            @else
                @php $selected = '' @endphp
            @endif
            <option value="<?= $key ?>" <?= $selected ?>><?= $value; ?></option>
        @endforeach

    </select>


    @include('admin.report.productFilter.checkboxSave', compact('filter'))

</div>

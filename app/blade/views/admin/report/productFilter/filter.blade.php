<div class="filter">
    <div class="title">{!!$filter->title ?? ''!!}</div>

{{--@deb--}}
    <select {!!$filter->name ?? ''!!} select-new>
        {!!$filter->emptyOption ?? ''!!}
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

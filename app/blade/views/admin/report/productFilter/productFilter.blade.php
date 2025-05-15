<form method='POST' class='list-filter'>

    @foreach($filterPanel as $filter)
        @include('admin.report.productFilter.filter', compact('filter'))
    @endforeach
    <button class='btn btn-primary filter-button' type='subsmit'>Фильтровать</button>
</form>

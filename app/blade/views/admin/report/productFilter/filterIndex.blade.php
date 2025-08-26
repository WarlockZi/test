@extends('layouts.admin.admin')

@section('content')
    <div class="products-filter">
        <div class="filter-wrap">
            <div class="filter-badge-title">Фильтры</div>

            <form method='POST' class='list-filter'>

                @foreach($filterPanel as $filter)
                    @include('admin.report.productFilter.filter', compact('filter'))
                @endforeach
                <button class='btn btn-primary filter-button' type='subsmit'>Фильтровать</button>
            </form>

        </div>

        @include('admin.report.productFilter.filterString', compact('filterString'))
{{--    @php(xdebug_break())--}}

        @include('admin.components.table.tableStandAlone', ['data'=>$productsTable])

    </div>
@endsection

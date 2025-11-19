@extends('layouts.admin.admin')

@section('content')
    <div class="products-filter">
        <div class="filter-wrap">
            @include('admin.report.productFilter.panel',compact('filterPanel'))
        </div>

        @include('admin.report.productFilter.filterString', compact('filterString','initialFilters'))

        @include('admin.components.table.tableStandAlone', ['data'=>$filterTable])

    </div>
@endsection

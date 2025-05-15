@extends('layouts.admin.admin')

@section('content')
    <div class="products-filter">
        <div class="filter-wrap">
            <div class="filter-badge-title">Фильтры</div>

            @include('admin.report.productFilter.productFilter')
        </div>

        @include('admin.report.productFilter.filterString', compact('filterString'))

        @include('admin.components.table.tableStandAlone', ['data'=>$productsTable])

    </div>
@endsection

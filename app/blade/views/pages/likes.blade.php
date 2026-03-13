@extends('layouts.main.main')

@section('content')

@if(isset($likes)&&$likes->count())

    @include('admin.components.table.tableStandAlone', ['data'=>$content])
@else
    <h1>Понравившиеся товары</h1>
    <div>Вы пока не выбрали ни одного товара</div>
@endif

@endsection
@extends('layouts.admin.admin')

@section('content')

    <div data-jsmodule="Promotion"></div>
    @include('admin.components.table.tableStandAlone',['data'=>$data])
@endsection
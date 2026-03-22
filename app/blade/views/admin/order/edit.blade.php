@extends('layouts.admin.admin')

@section('content')
{{--@deb--}}
    @include('admin.components.table.tableStandAlone',['data'=>$table])

@endsection
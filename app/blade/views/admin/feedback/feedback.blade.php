@extends('layouts.admin.admin')

@section('content')
    @include('admin.components.table.tableStandAlone',['data'=>$undone])
    @include('admin.components.table.tableStandAlone',['data'=>$done])
@endsection
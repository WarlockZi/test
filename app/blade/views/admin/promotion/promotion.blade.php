@extends('layouts.admin.admin')

@section('content')
    @include('admin.components.table.adminTableStandAlone',['data'=>$data])
@endsection
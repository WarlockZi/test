@extends('layouts.admin.admin')

@section('content')
{{--    @deb--}}
    @include('admin.components.table.adminTableStandAlone',['data'=>$heroCategories])

@endsection
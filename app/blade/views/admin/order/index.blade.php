@extends('layouts.admin.admin')

@section('content')
    @include('admin.components.table.tableStandAlone', ['data'=>$unsubmittedTable])
    @include('admin.components.table.tableStandAlone', ['data'=>$submittedTable])
{{--    {!! $unsubmittedTable !!}--}}
{{--    {!! $submittedTable !!}--}}

@endsection
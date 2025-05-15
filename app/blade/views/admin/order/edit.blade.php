@extends('layouts.admin.admin')

@section('content')

    @include('admin.components.table.table',['data'=>$table])

@endsection
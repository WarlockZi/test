@extends('layouts.admin.admin')

@section('content')

    @include('admin.components.table.default', ['data'=>$data])

@endsection

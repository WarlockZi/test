@extends('layouts.admin.admin')

@section('content')

{{--    @php xdebug_break() @endphp--}}
    @include('admin.components.table.default', ['data'=>$data])

@endsection

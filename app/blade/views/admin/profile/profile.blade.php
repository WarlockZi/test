@extends('layouts.admin.admin')

@section('content')

    @php xdebug_break(); @endphp
    @include('admin.components.catalogItem.index', compact('catItem'))

@endsection
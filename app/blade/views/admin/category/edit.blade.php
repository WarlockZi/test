@extends('layouts.admin.admin')

@section('content')

{{--    @php xdebug_break(); @endphp--}}
    @include('components.breadcrumbs.index')

    @include('admin.components.catalogItem.index')

@endsection

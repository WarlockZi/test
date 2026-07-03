@extends('layouts.admin.admin')

@section('content')
{{--@deb--}}

        @include('components.breadcrumbs.index', compact('breadcrumbs'))
        @include('admin.components.catalogItem.index')


@endsection
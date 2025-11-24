@extends('layouts.admin.admin')

@section('content')

    @include('admin.components.catalogItem.index', compact('catItem'))

@endsection
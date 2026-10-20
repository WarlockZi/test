@extends('layouts.main.main')

@section('content')
    <div data-jsmodule="profile">
        @include('admin.components.catalogItem.index', compact('catItem'))
    </div>

@endsection
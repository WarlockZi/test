@extends('layouts.admin.admin')

@section('content')

{{--    @deb--}}
    @if ($catItem)

        @include('components.breadcrumbs.index', compact('breadcrumbs'))
        @include('admin.components.catalogItem.index', compact('catItem'))

    @else
        <div>Такого товара нет</div>
        <br>
        <a href="/adminsc/category">Перейти в каталог</a>
    @endif

@endsection
@extends('layouts.main.main')

@section('content')

    <h1>Понравившиеся товары</h1>

    @isset($liked_products)
        @if(!empty($liked_products))

            <div data-jsmodule="like" class="likes-page">
                <div class="products">
                    <div class="product-wrap">

                        @foreach($liked_products as $product)
                            @include('category.product_card', compact('product'))
                        @endforeach
                    </div>
                </div>

            </div>
        @else
            <div class="empty-state">
                <p>Вы пока не выбрали ни одного товара</p>
                {{--                <a href="{{ route('products.index') }}" class="btn">Смотреть товары</a>--}}
                <a href="{{'/'}}" class="btn">Смотреть товары</a>
            </div>
        @endif
    @else
        <div class="empty-state">
            <p>Вы пока не выбрали ни одного товара</p>
            {{--            <a href="{{ route('products.index') }}" class="btn">Смотреть товары</a>--}}
        </div>
    @endisset

@endsection
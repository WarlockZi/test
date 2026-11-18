@extends('layouts.main.main')

@section('title', 'Корзина')
@section('description', 'Корзина.')
@section('keywords', 'Корзина')


@section('content')

    <div class="cart" data-jsmodule="cart">

        <h1>Корзина</h1>

        <a class="orders-link" href="/order">Заказы</a>

{{--        @deb--}}
        @php($emptyCart= empty($cart) && empty($_SESSION['cart_items']))

        @if(!$emptyCart)
            <div class="content">
                <div class="table">

                    @if (\app\service\AuthService\AuthService::accountId())
                        @include('cart.cartProductsAccount')
                    @else
                        @include('cart.cartProductsGuest')
                    @endif
                </div>

            </div>
        @endif
        <div class="order-in-process none">
            Ваш заказ взят в обработку
        </div>

{{--@deb--}}
        <div class="empty-cart {{$emptyCart?'':'none'}}">
            Корзина пуста
        </div>

    </div>
@endsection

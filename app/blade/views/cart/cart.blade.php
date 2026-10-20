@extends('layouts.main.main')

@section('title', 'Корзина')
@section('description', 'Корзина.')
@section('keywords', 'Корзина')


@section('content')

    <div class="cart" data-jsmodule="cart">

        <h1>Корзина</h1>

        <a href="/order">Заказы</a>
        @if(empty($order['products']) && empty($_SESSION['cart_items']))
            <div class="empty-cart {!!(empty($order) || !isset($order['products']))?'none':''!!}">
                Корзина пуста
            </div>
        @else

            <div class="content">
                <div class="table">
                    @if (\app\service\AuthService\AuthService::accountId())
                        @include('cart.cartProducts')
                    @else
                        @include('cart.guestCartProducts')
                    @endif
                </div>

            </div>
        @endif

    </div>
@endsection

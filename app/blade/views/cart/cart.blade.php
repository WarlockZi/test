@extends('layouts.main.main')

@section('title', 'Корзина')
@section('description', 'Корзина.')
@section('keywords', 'Корзина')


@section('content')

    <div class="cart">

        <h1>Корзина</h1>
        {{--@deb--}}
        @if (empty($order) || !isset($order['products']))

            <div class="content">

                <div class="table" data-order-id="{!!$order['id']!!}">
                    @include('cart.cartProducts')
                </div>

            </div>
    </div>
    @endif

    <div class="empty-cart {!!(empty($order) || !isset($order['products']))?'none':''!!}">
        Корзина пуста
    </div>

@endsection

@extends('layouts.main.main')

@section('title', 'Заказы')
@section('description', 'Заказы.')
@section('keywords', 'Заказы')


@section('content')

    <div class="orders" data-jsmodule="orders">

        <h1>Заказы</h1>
        {{--                @deb--}}
        @if(empty($orders))
            <div class="empty-cart">
                Заказов нет
            </div>
        @else

            @foreach($orders as $o_id=>$order)
                @deb
                <div class="order">
                    <div class="order-title">
                        @php
                            $orderCopy = $order;
                            $first_product = array_pop($orderCopy);
                            $order_date = data_get($first_product, [0, 'order', 'created_at']);
                            $order_id = data_get($first_product, [0, 'order', 'id']);
                        @endphp
                        Заказ {!!$order_id??'***'!!} от {!!$order_date??'***'!!}
                    </div>
                    @foreach($order as $product)
                        <div class="product">
                            <div class="product-image">
                                <img src="{!!$product[0]['product']['mainImage']!!}" alt="">
                            </div>
                            {{--                                    @deb--}}
                            <a href="/product/{!!$product[0]['product']['slug']!!}"
                               class="product-name">{!!$product[0]['product']['name']!!}</a>

                            <div class="order-items">
                                @foreach($product as $order_item)
                                    <div class="order-item">
                                        <div class="unit-name">
                                            {!!$order_item['order_unit']['name']!!}
                                        </div>
                                        <div class="count">
                                            {!!$order_item['count']!!}
                                        </div>
                                        <div class="price">
                                            {!!$order_item['price']!!}
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    @endforeach
                </div>
            @endforeach

        @endif

    </div>
@endsection

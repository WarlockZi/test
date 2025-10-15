<div class="shippable-table"
     data-price='{{$product['price']}}'
     data-1sid='{{$product['1s_id']}}'
>
    <button class='button blue-button'>Добавить</button>
    <div class="green-button-wrap none">
        <button class='button green-button'>Перейти в корзину</button>

{{--            @php(xdebug_break())--}}
                @foreach($product['shippable_units'] as $shippableUnit)

                    <div
                            unit-row
                            class="unit-row"
                            {{--                    @php(xdebug_break())--}}
                            data-order_product_id="{!! $orderItem['order_product_id']??''!!}"
                            data-product_unit_id="{!! $orderItem['product_unit_id']??''!!}"
                    >
                        <input
                                type="text"
                                class="input"
                                value="{!! $orderItem['count']??0 !!}"
                                onclick="this.value??'';"
                        >

                        <div class="unit-name">
                            <span class="name">{!! $shippableUnit['name'] !!}</span>

                            @include('product.card.shippableDescription',compact('shippableUnit','orderItem'))

                        </div>

                        <div class="arrows">
                            <div class="arrow plus"></div>
                            <div class="arrow minus"></div>
                        </div>

                    </div>

                @endforeach

    </div>
</div>

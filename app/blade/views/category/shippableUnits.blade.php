<div class="shippable-table"
     data-price='{{$product->price}}'
     data-product_1s_id='{{$product['1s_id']}}'
>
    <button class='button blue-button'>Добавить</button>
    <div class="green-button-wrap none">
        <button class='button green-button'>Перейти в корзину</button>

        @foreach($product['units'] as $unit)

            @if($order)
                @foreach($order['products'] as $OrderProduct)
{{--                    @deb--}}
                    @if (in_array($product['1s_id'], $OrderProduct))
                        @php($orderProduct=$OrderProduct)

                        @foreach($OrderProduct['orderitems'] as $oi)

                            @if ($unit['id']==$oi['unit_id'])
                                @php($orderItem=$oi)
                            @endif
                        @endforeach

                    @endif
                @endforeach
            @endif

            <div
                    unit-row
                    class="unit-row"
                    data-product_1s_id="{!! $product['1s_id']??''!!}"
                    data-unit_id="{!! $unit['id']??''!!}"
            >
                <input
                        type="text"
                        class="input"
                        value="{!! $orderItem['count']??0 !!}"
                        onclick="this.value??'';"
                >

                <div class="unit-name">
                    <span class="name">{!!$unit['name']!!}</span>
{{--                                        @deb--}}
                    {{--                           @if($shippableTable->description)--}}
                    <div class="description text-small">
                        <span class="contains">{!!$unit['pivot']['multiplier']??0 !!} {!!$product['base_unit']['name']??''!!}</span>
                        <span class="cost"
                              data-cost="{{$unit['pivot']['price']??0}}">{{$unit['pivot']['price']??0}} ₽</span>
                    </div>

                </div>

                <div class="arrows">
                    <div class="arrow plus"></div>
                    <div class="arrow minus"></div>
                </div>

            </div>

        @endforeach

    </div>
</div>
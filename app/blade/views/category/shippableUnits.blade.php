<div class="shippable-table"
     data-price='{{$product->price}}'
     data-product_1s_id='{{$product['1s_id']}}'
>
{{--    <button class='button blue-button'>Добавить</button>--}}
    <div class="green-button-wrap">
        <button class='button green-button'>Перейти в корзину</button>

{{--        @deb--}}
        @foreach($product['shippable_units'] as $unit)

            @if($order && $order['products'])
                @php
                    foreach ($order['products'] as $OrderProduct){
                        if (in_array($product['1s_id'], $OrderProduct)){
                            $orderProduct=$OrderProduct;
                            foreach ($OrderProduct['orderitems'] as $oi){
                                if ($unit['id']==$oi['product_unit']['unit']['id']){
                                    $orderItem=$oi;
                                }
                            }
                        }
                    }
                @endphp
            @endif

            <div
                    unit-row
                    class="unit-row"
                    data-product_1s_id="{!!$product['1s_id']??''!!}"
                    data-unit_id="{!!$unit['id']??''!!}"
            >
                <input
                        type="text"
                        class="input"
                        value="{!!$orderItem['count']??0!!}"
                        onclick="this.value??'';"
                >

                <div class="unit-name">{!!$unit['name']!!}</div>

{{--                        <span class="contains">{!!$unit['pivot']['divider']??0!!} {!!$product['base_unit']['name']??''!!}</span>--}}
                        <div class="cost" data-cost="{{$unit['pivot']['price']??0}}">
                            {{$unit['pivot']['price']?number_format($unit['pivot']['price'],2,'.',' '):0}}
                        </div>
                        <div class="currency"> ₽</div>


                <div class="arrows">
                    <div class="arrow plus"></div>
                    <div class="arrow minus"></div>
                </div>

            </div>

        @endforeach

    </div>
</div>
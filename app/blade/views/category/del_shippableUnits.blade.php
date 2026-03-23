<div class="shippable-table"
     data-product_1s_id='{{$product['1s_id']}}'
>

    <div class="green-button-wrap">
        <button class='button green-button'>Перейти в корзину</button>

        @foreach($product['shippable_units'] as $shippable)

            @if($order && $order['products'])

                @php
                    $count = 0;
                        foreach ($order['products'] as $OrderProduct){
                            if (in_array($product['1s_id'], $OrderProduct)){

                                foreach ($OrderProduct['orderitems'] as $orderItem){
                                     if (isset($orderItem['product_unit']['unit']['id'])) {
                                        if ($orderItem['product_unit']['unit']['id']==$shippable['id']){
                                            $count = $orderItem['count'];
                                            break;
                                        }
                                     }
                                }
                            }
                        }
                @endphp
            @endif

            <div
                    unit-row
                    class="unit-row"
                    data-unit_id="{!!$shippable['id']??''!!}"
            >
                <input
                        type="text"
                        class="input"
                        value="{!!$count??0!!}"
                        onclick="this.value??'';"
                >

                <div class="unit-name">{!!$shippable['name']!!}</div>

                <div class="cost"
                     data-cost="{{$shippable['pivot']['price']??0}}">
                    {{$shippable['pivot']['price']?number_format($shippable['pivot']['price'],2,'.',' '):0}}
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
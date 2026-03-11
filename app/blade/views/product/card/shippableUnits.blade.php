<div class="shippable-table"
     data-price='{{$product['price']}}'
     data-1sid='{{$product['1s_id']}}'
>

    <div class="green-button-wrap">
        <button class='button green-button'>Перейти в корзину</button>

        @foreach($product['shippable_units'] as $shippableUnit)

            <div
                    unit-row
                    class="unit-row"
                    data-product_1s_id="{!!$product['1s_id']??''!!}"
                    data-unit_id="{!!$shippableUnit['id']??''!!}"
            >
                @if($variables['orderProduct'])
                    @php($count = 0)
                    @foreach($orderProduct as $orderitem)

                        @if(!empty($orderitem['product_unit']))

                            @if($orderitem['product_unit']['unit_id']==$shippableUnit['id'])
                                @php
                                    $count = $orderitem['count'];
                                    break;
                                @endphp
                            @endif
                        @endif
                    @endforeach
                @endif

                <input
                        type="text"
                        class="input"
                        value="{!!$count??"0"!!}"
                        onclick="this.value??'';"
                >

                <div class="unit-name">{!!$shippableUnit['name']??'ед.'!!}</div>
                <div class="cost" data-cost="{{$shippableUnit['pivot']['price']??'0'}}">
                    {{number_format($shippableUnit['pivot']['price'],2, '.', ' ')??'0'}}
                </div>
                <div class="currency">₽</div>


            <div class="arrows">
                <div class="arrow plus"></div>
                <div class="arrow minus"></div>
            </div>

    </div>

    @endforeach

</div>
</div>

<div class="shippable-table"
     data-price='{{$product['price']}}'
     data-1sid='{{$product['1s_id']}}'
>
    <button class='button blue-button'>Добавить</button>
    <div class="green-button-wrap none">
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
{{--                        @deb--}}
                        @if(!empty($orderitem['unit'][0]))

                            @if($orderitem['unit'][0]['id']==$shippableUnit['id'])
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

                <div class="unit-name">
                    <span class="name">{!!$shippableUnit['name']??'ед.'!!}</span>

                    {{--                                @deb--}}
                    @include('product.card.shippableDescription',compact('shippableUnit'))

                </div>

                <div class="arrows">
                    <div class="arrow plus"></div>
                    <div class="arrow minus"></div>
                </div>

            </div>

        @endforeach

    </div>
</div>

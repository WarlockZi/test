<div class="shippable-table"
     data-price='{{$product->price}}'
     data-1sid='{{$product['1s_id']}}'
>

    @foreach($product['shippable_units'] as $shippable)

        @php($count = 0)
        @foreach($product['order_items'] as $orderitem)
            @php
                if(!empty($orderitem['unit'][0])&&$orderitem['unit'][0]['id']==$shippable['id']){
                    $count = $orderitem['count'];
                    break;
                }
            @endphp
            {{--            @deb--}}
        @endforeach

        <div
                unit-row
                class="unit-row"
                data-product_1s_id="{!! $product['1s_id']??''!!}"
                data-unit_id="{!! $shippable['id']??''!!}"

                {{--                data-order_product_id="{!! $oItem['order_product_id']??''!!}"--}}
                {{--                data-prodct_unit_id="{!! $oItem['prodct_unit_id']??''!!}"--}}
        >
            <input
                    type="text"
                    class="input"
                    value="{!! $count??0 !!}"
                    onclick="this.value??'';"
            >

            <div class="unit-name">
                <span class="name">{!! $shippable['name'] !!}</span>

                <div class="ps-2 description text-small">
                        <span class="cost"
                              data-cost="{{$shippable['pivot']['price']}}">
                            {{$shippable['pivot']['price']}} ₽
                        </span>
                    {{--        @deb--}}
                    <span class="contains">({!! $shippable['pivot']['multiplier'] !!}
                        {!! $product['base_unit']['name']?? '-' !!})</span>
                </div>


            </div>

            <div class="arrows">
                <div class="arrow plus"></div>
                <div class="arrow minus"></div>
            </div>


        </div>

    @endforeach
</div>

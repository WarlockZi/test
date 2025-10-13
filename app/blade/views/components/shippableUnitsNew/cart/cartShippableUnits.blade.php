<div class="shippable-table"
     data-price='{{$product->price}}'
     data-1sid='{{$product['1s_id']}}'
>

@foreach($product['shippable_units'] as $shippable)

        @foreach($product['order_items'] as $oItem)

            <div
                    unit-row
                    class="unit-row"

                    data-order_product_id="{!! $oItem['order_product_id']??''!!}"
                    data-prodct_unit_id="{!! $oItem['prodct_unit_id']??''!!}"
            >
                <input
                        type="text"
                        class="input"
                        value="{!! $orderItem['count']??0 !!}"
                        onclick="this.value??'';"
                >

                <div class="unit-name">

                    <span class="name">{!! $oItem['unit'][0]['name'] !!}</span>

                    <div class="ps-2 description text-small">
                        <span class="cost"
                              data-cost="{{$oItem['unit'][0]['pivot']['price']}}">
                            {{$oItem['unit'][0]['pivot']['price']}} ₽
                        </span>
                        <span class="contains">({!! $oItem['multiplier'] !!}
                            {!! $product['base_unit']['name'] !!})</span>
                    </div>


                </div>

                <div class="arrows">
                    <div class="arrow plus"></div>
                    <div class="arrow minus"></div>
                </div>


            </div>

        @endforeach
@endforeach
</div>

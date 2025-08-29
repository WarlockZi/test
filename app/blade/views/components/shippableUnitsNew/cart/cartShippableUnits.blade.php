<div class="shippable-table"
     data-price='{{$product->price}}'
     data-1sid='{{$product['1s_id']}}'
>

    @foreach($product['shippable_units'] as $unit)

        @foreach($product['order_items'] as $order_Item)

            @if($order_Item['unit_id']===$unit['id'])
                @php($orderItem = $order_Item)
            @endif
        @endforeach


        <div
                unit-row
                class="unit-row"
                data-orderitem-id="{!! $orderItem['id']??''!!}"
                data-unit-id="{!! $unit['id']??''!!}"
        >
            <input
                    type="text"
                    class="input"
                    value="{!! $orderItem['count']??0 !!}"
                    onclick="this.value??'';"
            >

            <div class="unit-name">
                <span class="name">{!! $unit['full_name'] !!}</span>

                {{--        @if($shippableTable->description)--}}
                {{--            <div class="description text-small">--}}
                {{--                <span class="contains">{!! $unit['multiplier'] !!} {!! $unit['base_unit_name'] !!}</span>--}}
                {{--                <span class="cost" data-cost="{{$unit['unit_price']}}">{{$unit['formatted_unit_price']}} ₽</span>--}}
                {{--            </div>--}}
                {{--        @endif--}}

            </div>

            <div class="arrows">
                <div class="arrow plus"></div>
                <div class="arrow minus"></div>
            </div>


        </div>

    @endforeach

</div>
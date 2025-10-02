<div class="shippable-table"
     data-price='{{$product->price}}'
     data-1sid='{{$product['1s_id']}}'
>

{{--                @php(xdebug_break())--}}
    @foreach($product['shippable_units'] as $unit)
        {{--@php(xdebug_break())--}}
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
{{--                @php(xdebug_break())--}}
                <span class="name">{!! $unit['name'] !!}</span>

                    <div class="ps-2 description text-small">
                        <span class="cost"
                              data-cost="{{$unit['price1s']['value']}}">
                            {{$unit['price1s']['value']}} ₽
                        </span>
                        <span class="contains">({!! $unit['pivot']['multiplier'] !!}
                            {!! $product['base_unit'][0]['name'] !!})</span>
                    </div>


            </div>

            <div class="arrows">
                <div class="arrow plus"></div>
                <div class="arrow minus"></div>
            </div>


        </div>

    @endforeach

</div>
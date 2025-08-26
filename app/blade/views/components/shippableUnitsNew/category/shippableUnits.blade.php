<div class="shippable-table"
     data-price='{{$product->price}}'
     data-1sid='{{$product['1s_id']}}'
>
    <button class='button blue-button'>Добавить</button>
    <div class="green-button-wrap none">
        <button class='button green-button'>Перейти в корзину</button>
{{--@php(xdebug_break())--}}
        @foreach($product['shippable_units'] as $unit)

            @foreach($order['products'] as $OrderProduct)
                @if (in_array($product['1s_id'], $OrderProduct))
                    @php($orderProduct=$OrderProduct)

                    @foreach($OrderProduct['order_items'] as $OrderItem)
{{--                        @php(xdebug_break())--}}
                        @if ($unit['id']==$OrderItem['unit_id'])
                            @php($orderItem=$OrderItem)
                        @endif
                    @endforeach

                @endif
            @endforeach

            <div
                    unit-row
                    class="unit-row"
                    data-orderitem-id="{!! $orderItem['id']??''!!}"
                    data-unitId="{!! $unit['id']??''!!}"
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
</div>
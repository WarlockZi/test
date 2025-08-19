<div class="shippable-table"
     data-price='{{$product->price}}'
     data-1sid='{{$product['1s_id']}}'
>

    {{--    <div class="green-button-wrap flex">--}}
    {{--        <button class='button green-button'>Перейти в корзину</button>--}}


    @foreach($product['shippableUnits'] as $unit)
        {{--            @foreach($product['order_items'] as $orderItem)--}}
        @php xdebug_break() @endphp
        @php $orderItem = array_filter(
            $product['order_items'],
               function($oi)use($unit){
//         xdebug_break();
               return $oi['unit_id']===$unit['id'];
                    }
               )
        @endphp

        @include('components.shippableUnitsNew.cartShippableUnitRow', compact('unit', 'orderItem'))
        {{--            @endforeach--}}
    @endforeach


{{--    </div>--}}

</div>
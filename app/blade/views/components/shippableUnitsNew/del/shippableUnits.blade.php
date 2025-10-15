{{--@php xdebug_break() @endphp--}}

<div class="shippable-table"
     data-price='{{$product->price}}'
     data-1sid='{{$product['1s_id']}}'
>

    <button class='button blue-button'>Добавить</button>


    <div class="green-button-wrap none">
        <button class='button green-button'>Перейти в корзину</button>


        @foreach($product['shippableUnits'] as $unit)
            {{--                @php xdebug_break() @endphp--}}
            @include('components.shippableUnitsNew.del.shippableUnitRow', compact('unit','product'))
        @endforeach

    </div>


</div>
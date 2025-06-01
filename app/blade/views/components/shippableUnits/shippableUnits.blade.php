<div class="shippable-table"
     data-price='{{$product->price}}'
     data-1sid='{{$product['1s_id']}}'
>
    @if($shippableTable->blueButton)
        <button class='button blue-button'>Добавить</button>
    @endif
    @if($shippableTable->greenButton)
        <div class="green-button-wrap">
            <button class='button green-button'>Перейти в корзину</button>
            @endif

            @foreach($product->shippableUnits as $unit)
{{--                @php xdebug_break() @endphp--}}
                @include('components.shippableUnits.shippableUnitRow', ['row'=>$shippableTable->rows[$product['1s_id']][$unit['id']]])
            @endforeach
            @if($shippableTable->greenButton)
        </div>
    @endif

</div>


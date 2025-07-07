@php
    use    \app\view\components\Sshippable\ShippUnits;
    //    xdebug_break()
@endphp

<div class="shippable-table"
     data-price='{{$product->price}}'
     data-1sid='{{$product['1s_id']}}'
>
    <button class='button blue-button'>Добавить</button>

    <div class="green-button-wrap">

        <button class='button green-button'>Перейти в корзину</button>

        @foreach($product->shippableUnits as $unit)
            @include('category.shippableUnitRow', ['row'=>ShippUnits::row($product, $unit)])
        @endforeach

    </div>

</div>


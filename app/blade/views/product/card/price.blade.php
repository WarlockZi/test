{{--@php xdebug_break() @endphp--}}

<div class="price">

    <div class="new-price">
        {!! $product['base_unit_price'] !!}
        {!! $product->baseUnit['base_unit_name']!!}
    </div>

</div>
<div class="price-units ">
    @include('components.shippableUnits.shippableUnits', compact('shippableTable'))
</div>
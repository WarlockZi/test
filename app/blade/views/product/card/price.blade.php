
<div class="price">

    <div class="new-price">
        {!! $product['price'] !!}
        {!! $product['base_unit']['name']!!}
    </div>

</div>
<div class="price-units ">
    @include('components.shippableUnitsNew.product.shippableUnits', ['shippableUnits'=>$product['shippable_units']])
</div>
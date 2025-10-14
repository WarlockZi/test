<div class="product-info">


    @include('components.card_panel.product_card_panel')

    <div class="art">Арт. {!! $product['art'] !!} </div>

    {{--            @php(xdebug_break())--}}
    <div>
        {{$product['base_unit']['pivot']['price']}} р / {{$product['base_unit']['name']}}
    </div>

    <div class="price">

        <div class="new-price">
            {{--        {!! $product['price'] !!}--}}
            {{--        {!! $product['base_unit']['name']!!}--}}
        </div>

    </div>
    <div class="price-units ">
        @if($product['shippable_units'])
            @include('components.shippableUnitsNew.product.shippableUnits', ['shippableUnits'=>$product['shippable_units']])
        @endif
    </div>
    @include( 'product.card.promotion')

    <div class="instore">
        <p>Статус: в наличии</p>
    </div>

    @include( 'product.card.promotion')


</div>


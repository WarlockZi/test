<div class="product-info">

    @include('components.card_panel.product_card_panel')

{{--    @deb--}}
    <div class="art">Арт. {!!$product['art']!!} </div>

    <div>
        {{$product['base_unit']['pivot']['price']}} ₽ / {{$product['base_unit']['name']}}
    </div>

    <div class="price">

        <div class="new-price"></div>

    </div>
    <div class="price-units ">

        @include('product.card.shippableUnits')
    </div>
    @include( 'product.card.promotion')

    <div class="instore">
        <p>Статус: в наличии</p>
    </div>

    @include( 'product.card.promotion')


</div>


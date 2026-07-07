<div class="product-info" itemprop="offers" itemscope itemtype="https://schema.org/Offer">

    @include('components.card_panel.product_card_panel')

{{--    @deb--}}
    <div class="art">Арт. {!!$product['art']!!} </div>

    <div>
        <meta itemprop="priceCurrency" content="RUB">
        <span itemprop="price">{!!number_format(data_get($product,'base_unit.pivot.price')??0, 2, '.', ' ')??'нет цены'!!}</span>
         ₽ / {!!$product['base_unit']['name']??'единиц'!!}
    </div>

    <div class="price">

        <div class="new-price"></div>

    </div>
    <div class="price-units">

        @include('product.card.shippableUnits')
    </div>
    @include( 'product.card.promotion')

    <div class="instore">
        @if($product['instore'])
            <link itemprop="availability" href="https://schema.org/InStock">
            <p>Статус: в наличии</p>
        @else
            <link itemprop="availability" href="https://schema.org/OutOfStock">
            <p>Статус: под заказ</p>
        @endif

    </div>

    @include( 'product.card.promotion')


</div>


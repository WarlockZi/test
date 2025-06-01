@php

@endphp

<div class="product-info">


    @include('components.card_panel.product_card_panel')

    <div class="art">Арт. <?= $product->art ?></div>

    @include( 'product.card.price')
    @include( 'product.card.promotion')

    <div class="instore">
        <p>Статус: в наличии</p>
    </div>

    @include( 'product.card.promotion')


</div>


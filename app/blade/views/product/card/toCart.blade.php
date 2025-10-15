<div class="product-info">


    @include('components.card_panel.product_card_panel')

    <div class="art">Арт. {!! $product['art'] !!} </div>

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


        {{--        @php(xdebug_break())--}}

        @include('product.card.shippableUnits', ['shippableUnits'=>$product['shippable_units']])

    </div>
    @include( 'product.card.promotion')

    <div class="instore">
        <p>Статус: в наличии</p>
    </div>

    @include( 'product.card.promotion')


</div>


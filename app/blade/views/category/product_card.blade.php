<div
        class="column"
        data-instore="{!!$product['instore'] ?? 0!!}"
        data-product_1s_id="{!!$product['1s_id'] ?? 0!!}"
>
    {!!isset($product->activePromotions) && $product->activePromotions->count()
        ? "<div class='promotion'>Акция</div>"
        : ''!!}
    <a
            href="/product/{!!$product['slug']!!}" class="product">
        <h3 class="name">{!!$product['print_name']!!}</h3>
        <img src="{!!$product['main_image']!!}"
             alt="{!!$product['name']!!}"
             loading="lazy">
        <div class="footer">

            @if(isset($product['baseUnit']))
                <p>Цена: {!!$product['instore']
                        ? "{$product['base_unit']['pivot']['price']} р."
                        : "<span class='danger'>от</span> {$product['base_unit']['pivot']['price']} р."!!}
                </p>
            @endif

            <p>Статус: {!!$product['instore']
                    ? "<span class='success'>в наличии</span>"
                    : "<span class='danger'>под заказ</span>"!!}</p>
            <p>Артикул: {!!$product['art'] ?? ''!!}</p>
        </div>
    </a>

    @php
        $showToCartButton = true;
        $plus_minus_buttons = true;
        $orderitems = $cart[$product['1s_id']]['cart_items']??[];
    @endphp

    @include('components.shippable_units.shippableUnits', compact('product', 'orderitems', 'showToCartButton', 'plus_minus_buttons'))


    @include('components.card_panel.product_card_panel', compact('product'))

</div>

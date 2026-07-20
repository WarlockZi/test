<div
        class="column"
        data-instore="<?= $product->instore ?? 0; ?>"
        data-product_1s_id="<?= $product['1s_id'] ?? 0; ?>"
>
    <?= isset($product->activePromotions) && $product->activePromotions->count()
        ? "<div class='promotion'>Акция</div>"
        : ''; ?>
    <a
            href="/product/<?= $product->slug; ?>" class="product">

        <h3 class="name"><?= $product->print_name; ?></h3>
        <img src="<?= $product->mainImagePath ?>"
             alt="<?= $product->name ?>"
             loading="lazy">
        <div class="footer">

            <p>Цена: <?= $product->instore
                    ? $product->baseUnitPrice
                    : "<span class='danger'>от</span> " . $product->baseUnitPrice; ?></p>
            <p>Статус: <?= $product->instore
                    ? "<span class='success'>в наличии</span>"
                    : "<span class='danger'>под заказ</span>"; ?></p>
            <p>Артикул: <?= $product->art ?? ''; ?></p>
        </div>
    </a>


    @include('product.card.shippableUnits')
{{--    @include('components.shippableUnitsNew.shippableUnits')--}}

    @include('components.card_panel.product_card_panel', compact('product'))

    @if (isset($txt))
        <div class="txt"><?= $product->txt ?? '' ?></div>
    @endif

</div>

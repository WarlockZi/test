<div
        class="column"
        data-instore="<?= $product['instore'] ?? 0; ?>"
        data-1sid="<?= $product['1s_id'] ?? 0; ?>"
>
    <?= isset($product->activePromotions) && $product->activePromotions->count()
        ? "<div class='promotion'>Акция</div>"
        : ''; ?>
    <a
            href="/product/<?= $product['slug']; ?>" class="product">

        <h3 class="name"><?= $product['print_name']; ?></h3>
        <img src="<?= $product['mainImage'] ?>"
             alt="<?= $product['name'] ?>"
             loading="lazy">
        <div class="footer">

            @if(isset($product['baseUnitPrice']))

                <p>Цена: <?= $product['instore']
                        ? $product['baseUnitPrice']
                        : "<span class='danger'>от</span> " . $product['baseUnitPrice']; ?></p>
            @endif
            <p>Статус: <?= $product['instore']
                    ? "<span class='success'>в наличии</span>"
                    : "<span class='danger'>под заказ</span>"; ?></p>
            <p>Артикул: <?= $product['art'] ?? ''; ?></p>
        </div>
    </a>

    {{--    @php(xdebug_break())--}}
    @include('components.shippableUnitsNew.category.shippableUnits', $product)

    @include('components.card_panel.product_card_panel', compact('product'))

</div>

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
{{--@deb--}}
        <h3 class="name"><?= $product['print_name']; ?></h3>

        <img src="{!!image($product['own_properties']['main_image'])!!}"
             alt="<?= $product['name'] ?>"
             loading="lazy">
        <div class="footer">

            @if(isset($product['baseUnit']))
                <p>Цена: <?= $product['instore']
                        ? $product['baseUnit']
                        : "<span class='danger'>от</span> " . $product['base_unit']['pivot']['price']; ?></p>
            @endif

            <p>Статус: <?= $product['instore']
                    ? "<span class='success'>в наличии</span>"
                    : "<span class='danger'>под заказ</span>"; ?></p>
            <p>Артикул: <?= $product['art'] ?? ''; ?></p>
        </div>
    </a>
{{--@deb--}}
    @include('category.shippableUnits', $product)

    @include('components.card_panel.product_card_panel', compact('product'))

</div>

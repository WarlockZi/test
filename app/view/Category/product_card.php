<div
        class="column"
        data-instore="<?= $product->instore ?? 0; ?>"
        data-1sid="<?= $product['1s_id'] ?? 0; ?>"
>
    <?= $product->activepromotions->count() ? "<div class='promotion'>Акция</div>" : '';; ?>
    <a
            href="/product/<?= $product->slug; ?>" class="product">

        <h3 class="name"><?= $product->print_name; ?></h3>
        <img src="<?= $product->mainImagePath ?>" alt="<?= $product->name ?>" loading="lazy">
        <div class="footer">

            <p>Цена: <?= $product->instore ? $product->baseUnitPrice : 'от '.$product->baseUnitPrice; ?></p>
            <p>Статус: <?= $product->instore ? "в наличии" : 'под заказ'; ?></p>
            <p>Артикул: <?= $product->art ?? ''; ?></p>
        </div>
    </a>
    <?= \app\view\share\shippable\ShippableUnitsTableFactory::create($product, 'category'); ?>

    <?= \app\view\share\card_panel\CardPanel::card_panel($product) ?>


</div>

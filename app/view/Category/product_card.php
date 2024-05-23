<div
        class="column"
        data-instore="<?= $product->instore ?? 0; ?>"
        data-1sid="<?= $product['1s_id'] ?? 0; ?>"
>
    <?= $case->showProductPromotionLable($product) ?>
    <a
            href="/product/<?= $product->slug; ?>" class="product">

        <h3 class="name"><?= $product->print_name; ?></h3>
        <img src="<?= $product->mainImagePath ?>" alt="<?= $product->name ?>" loading="lazy">
        <div class="footer">

            <p>Цена: <?= $product->instore?$product->baseUnitPrice:'уточняйте'; ?></p>
            <p>Статус: <?= $case->showProductStatus($product) ?></p>
            <p>Артикул: <?= $product->art ?? ''; ?></p>
        </div>
    </a>
    <?= \app\view\share\shippable\ShippableUnitsTableFactory::create($product, 'category'); ?>


    <?php if ($admin): ?>

        <a href="/adminsc/product/edit/<?= $product->id ?>" class="edit"><?= $edit ?></a>

    <?php endif; ?>

</div>

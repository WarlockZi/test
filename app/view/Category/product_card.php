<div
        class="column"
        data-instore="<?= $order->instore ?? 0; ?>"
        data-1sid="<?= $order['1s_id'] ?? 0; ?>"
>
    <?= isset($order->activePromotions) && $order->activePromotions->count()
        ? "<div class='promotion'>Акция</div>"
        : ''; ?>
    <a
            href="/product/<?= $order->slug; ?>" class="product">

        <h3 class="name"><?= $order->print_name; ?></h3>
        <img src="<?= $order->mainImagePath ?>" alt="<?= $order->name ?>" loading="lazy">
        <div class="footer">

            <p>Цена: <?= $order->instore ? $order->baseUnitPrice : "<span class='danger'>от</span> ".$order->baseUnitPrice; ?></p>
            <p>Статус: <?= $order->instore ? "<span class='success'>в наличии</span>" : "<span class='danger'>под заказ</span>"; ?></p>
            <p>Артикул: <?= $order->art ?? ''; ?></p>
        </div>
    </a>
    <?= \app\view\share\shippable\ShippableUnitsTableFactory::create($order, 'category'); ?>

    <?= \app\view\share\card_panel\CardPanel::card_panel($order) ?>


</div>

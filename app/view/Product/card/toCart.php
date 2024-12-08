<?php

use app\view\share\shippable\ShippableUnitsTableFactory;

?>

<div class="product-info">


    <?= \app\view\share\card_panel\CardPanel::card_panel($order) ?>
    <div class="art">Арт. <?= $order->art ?></div>

    <?php include __DIR__ . '/price.php' ?>
    <?php include __DIR__ . '/promotion.php' ?>

    <div class="instore">
        <p>Статус: в наличии</p>
    </div>

    <?= ShippableUnitsTableFactory::create($order, 'product'); ?>

</div>


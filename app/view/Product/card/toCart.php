<?php

use app\view\share\shippable\ShippableUnitsTableFactory;

?>

<div class="product-info">


    <?= \app\view\share\card_panel\CardPanel::card_panel($product) ?>
    <div class="art">Арт. <?= $product->art ?></div>

    <?php include __DIR__ . '/price.php' ?>
    <?php include __DIR__ . '/promotion.php' ?>

    <div class="instore">
        <p>Статус: в наличии</p>
    </div>

    <?= ShippableUnitsTableFactory::create($product, 'product'); ?>

</div>


<?php

use app\core\Icon;

?>

<div class="product-info">

    <div class="short-link"
         title='Скопировать короткую ссылку'
         data-shortLink= <?= $product->shortLink; ?>
    >
        <?= Icon::link(); ?>
    </div>
    <div class="art">Арт. <?= $product->art ?></div>

    <?php include __DIR__ . '/price.php' ?>
    <?php include __DIR__ . '/promotion.php' ?>

    <div class="instore">
        <p>Статус: в наличии</p>
    </div>

    <?= \app\view\share\ShippableUnitsTableFactory::create($product,'product' ); ?>

    </div>
</div>

<?php

use app\core\Icon;
use app\view\share\shippable\ShippableUnitsTableFactory;

?>

<div class="product-info">

    <?php if ($userIsAdmin): ?>
        <a href="/adminsc/product/edit/<?= $product->id ?>" class="edit"><?= Icon::edit(); ?></a>
    <?php endif; ?>
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

    <?= ShippableUnitsTableFactory::create($product, 'product'); ?>

</div>
</div>

<?php

use app\core\Icon;

?>

<div class="to-cart">

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

    <div class="button blue">Добавить в корзину</div>

    <div class="adjust none">
        <a href="/cart" class="button green">
            <span class='bigger'>В корзину</span>
        </a>

        <div class="plus-minus">
            <button tabindex="0" class="minus"><?= Icon::minus() ?></button>

            <span class="digit" contenteditable="true">1</span>
            <?php if ($product->shippableUnits->count()): ?>
                <span><?php include 'dopUnitsSelector.php' ?></span>
            <?php else: ?>
                <span><?= $product->baseUnit->name ?></span>
            <?php endif; ?>
            <button tabindex="0" class="plus">
                <?= Icon::plus1() ?>

            </button>
        </div>
    </div>
</div>

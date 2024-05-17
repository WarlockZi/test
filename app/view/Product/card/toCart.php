<?php

use app\core\Icon;

?>

<div class="shippable-table">

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
<!--    --><?php //= \app\view\Cart\CartView::cartTable($product);?>

    <div class="button blue">Добавить в корзину</div>

    <div class="adjust">
        <a href="/cart" class="button green">
            <span class='bigger'>В корзину</span>
        </a>

        <?php include dirname(dirname(__DIR__)).'/Category/toCart.php';?>

<!--        <div class="plus-minus">-->
<!--            <button tabindex="0" class="minus">--><?php //= Icon::minus() ?><!--</button>-->
<!---->
<!--            <span class="digit" contenteditable="true">1</span>-->
<!---->
<!--                <span>--><?php //include 'dopUnitsSelector.php' ?><!--</span>-->
<!---->
<!--            <button tabindex="0" class="plus">-->
<!--                --><?php //= Icon::plus1() ?>
<!---->
<!--            </button>-->
<!--        </div>-->
    </div>
</div>

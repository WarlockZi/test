<?php use app\core\Icon; ?>

<nav class="menu">
    <div class="header-catalog-menu">
        <? include 'searchPanel.php' ?>
        <div class="header-catalog-menu__wrap">
            <? include 'categories.php' ?>

            <ul class="utils">

                <a href="/catalog" class="util-item catalog" title="Каталог">
                    <?= Icon::catalog() ?>
                </a>


                <button class="util-item search" title="Поиск">
                    <?= Icon::search('feather'); ?>
                </button>

                <a href="/cart" class="util-item cart" title="Корзина">
                    <div class="count<?= $oItems->count() ? ' show' : ''; ?>"><?= $oItems->count(); ?></div>
                    <?= Icon::shoppingCart('feather') ?>
                </a>

                <a href="/promotion" class="util-item promotions" title="Акции">
                    <?= Icon::promotions() ?>
                </a>

                <? include 'mobileMenu.php' ?>
            </ul>

        </div>

    </div>
</nav>

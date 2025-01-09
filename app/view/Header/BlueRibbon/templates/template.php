<?php use app\core\Icon; ?>

<nav class="menu">
    <div class="header-catalog-menu">
        <? include 'search_panel.php' ?>
        <div class="header-catalog-menu__wrap">
            <? include 'categories.php' ?>

            <ul class="utils">

                <li>
                    <a href="/catalog" class="util-item catalog" title="Каталог">
                        <?= Icon::catalog() ?>
                    </a>
                </li>

                <li>
                    <button class="util-item search" title="Поиск">
                        <?= Icon::search('feather'); ?>
                    </button>
                </li>


                <li>
                    <a href="/cart" class="util-item cart-link" title="Корзина">

                        <? if ($oItemsCount): ?>
                            <div class="count show"><?= $oItemsCount; ?></div>
                        <? endif; ?>

                        <?= Icon::shoppingCart('feather') ?>
                    </a>
                </li>

                <li>
                    <a href="/like/page" class="util-item like" title="Избранное">
                        <?= Icon::heart() ?>
                    </a>
                </li>
                <li>
                    <a href="/compare/page" class="util-item compare" title="Сравнить товары">
                        <?= Icon::chart() ?>
                    </a>
                </li>
                <li>
                    <? include 'mobile_menu.php' ?>
                </li>
            </ul>

        </div>

    </div>
</nav>

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
                        <div class="count<?= $oItems->count() ? ' show' : ''; ?>"><?= $oItems->count(); ?></div>
                        <?= Icon::shoppingCart('feather') ?>
                    </a>
                </li>

                <li>
                    <a href="/promotion" class="util-item promotions" title="Акции">
                        <?= Icon::promotions() ?>
                    </a>
                </li>

                <li>
                    <? include 'mobile_menu.php' ?>
                </li>
            </ul>

        </div>

    </div>
</nav>

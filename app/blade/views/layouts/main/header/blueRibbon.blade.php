@php use app\view\components\Icon\Icon; @endphp

<nav class="menu">
    <div class="header-catalog-menu">
        @include ('layouts.main.header.blueRibbon.search_panel')
        <div class="header-catalog-menu__wrap">
            @include ('layouts.main.header.blueRibbon.search_panel')

            <ul class="utils">

                <li class="mob-burger">
                     @include('layouts.main.header.blueRibbon.mobile_menu')
                </li>

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

                        <?php if ($oItemsCount): ?>
                        <div class="count show"><?= $oItemsCount; ?></div>
                        <?php endif; ?>

                        <?= Icon::shoppingCart('feather') ?>
                    </a>
                </li>


                <li>
                    <a href="/compare/page" class="util-item compare" title="Сравнить товары">
                        <?= Icon::chart() ?>
                    </a>
                </li>
                <li>
                    <a href="/like/page" class="util-item like" title="Избранное">
                        <?= Icon::heart() ?>
                    </a>
                </li>

            </ul>

        </div>

    </div>
</nav>


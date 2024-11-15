<?php

use app\core\Icon;
use app\Services\CatalogMobileMenu\CatalogMobileMenuService;


?>

<button class="nav-top util-item">
    <span class="hamburger material-icons" id="ham"><?= Icon::menu('feather') ?></span>
</button>

<nav class="nav-drill">
    <ul class="nav-items nav-level-1">
        <li class="nav-item nav-expand">
            <a class="nav-link nav-expand-link" href="#">
                Каталог
            </a>

            <?=(new CatalogMobileMenuService())->get();?>

        </li>
        <li class="nav-item">
            <a class="nav-link" href="/main/contacts">
                Контакты
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/main/news">
                Новости
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/promotion">
                Акции
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/main/about">
                О нас
            </a>
        </li>
    </ul>
</nav>
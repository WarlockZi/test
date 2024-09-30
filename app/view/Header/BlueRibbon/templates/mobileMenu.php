<?php

use app\core\Icon;

?>
<button class="util-item gamburger">
    <?= Icon::menu('feather') ?>
</button>

<nav class="mobile-menu">
    <ul class="wrap">
        <li>
            <a href="/main/contacts">Контакты</a>
        </li>
        <li>
            <a href="/main/requisites">Реквизиты</a>
        </li>
        <li>
            <a href="/main/about">О компании</a>
        </li>

        <hr>

        <li>
            <a href="/catalog">Каталог</a>
        </li>

    </ul>
</nav>
<?php

use app\core\Icon;

?>
<aside class="search-panel">

<!--    <menu class="search-filter">-->
<!--        <span>Искать:  </span>-->
<!--        <ul class="filters">-->
<!--            <li>-->
<!--                <input type="checkbox" class="filter" id="name">-->
<!--                <label for="name">по наименов.</label>-->
<!--            </li>-->
<!--            <li>-->
<!--                <input type="checkbox" class="filter" id="art">-->
<!--                <label for="art">по артикулу</label>-->
<!--            </li>-->
<!--        </ul>-->
<!--    </menu>-->
    <div class="input-group">
        <input type="text" class="text" placeholder="поиск">
        <button class="close"><?= Icon::close(); ?></button>
    </div>
    <ul class="result"></ul>

</aside>

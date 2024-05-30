<?php

use app\core\Icon;

?>
<div class="sync">

    <div class="container files">

        <div dnd data-path="xml"><?= Icon::plus() ?></div>

        <div class="button" id="logshow">Показать содержание лог файла</div>
        <div class="button" id="logclear">Очистить лог файл</div>
        <br>


        <div id="log_content"></div>
    </div>

    <div class="container">

        <div class="buttons-block">
            <div class="buttons-block-left">

                <div class="button" id="removecategories">Удалить категории</div>
                <div class="button" id="removeproducts">Удалить товары</div>
                <div class="button" id="removeprices">Удалить цены</div>
            </div>
            <div class="buttons-block-right">
                <div class="button" id="removeall">Удалить все</div>

            </div>
        </div>

        <BR>

        <div class="buttons-block">
            <div class="buttons-block-left">
                <div class="button" id="loadcategories">Загрузить категории</div>
                <div class="button" id="loadproducts">Загрузить товары</div>
                <div class="button" id="loadprices">Загрузить цены и количество</div>
            </div>
            <div class="buttons-block-right">
                <div class="button" id="loadall">Загрузить все</div>
            </div>
        </div>




        <BR>
        <a class="button"
           title="/adminsc/sync/init?type=catalog&mode=checkauth"
           href="/adminsc/sync/load">type=catalog -- mode=checkauth</a>
        <BR>
        <BR>
        <BR>
        <div class="button" id="">Фильтровать картинки</div>
        <BR>
        <hr>
        <BR>
        <BR>
        <a class="button" href="/adminsc/sync/part?type=catalog&mode=checkauth">/adminsc/sync/part?type=catalog&mode=checkauth</a>
        <a class="button" title="/adminsc/sync/part?type=catalog&mode=import"
           href="/adminsc/sync/part?type=catalog&mode=import">/adminsc/sync/part?type=catalog&mode=import</a>

    </div>

</div>


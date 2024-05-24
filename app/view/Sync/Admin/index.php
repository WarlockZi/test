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

                <div class="button" id="removecategorieswithpopup">Удалить категории</div>
                <div class="button" id="removeproductswithpopup">Удалить товары</div>
                <div class="button" id="removepriceswithpopup">Удалить цены</div>
            </div>
            <div class="buttons-block-right">
                <div class="button" id="removeall">Удалить все</div>

            </div>
        </div>

        <BR>

        <div class="buttons-block">
            <div class="buttons-block-left">
                <div class="button" id="loadcategorieswithpopup">Загрузить категории</div>
                <div class="button" id="loadproductswithpopup">Загрузить товары</div>
                <div class="button" id="loadpriceswithpopup">Загрузить цены и количество</div>
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


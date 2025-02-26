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

<!--        <div class="buttons-block">-->
<!--            <fieldset>-->
<!--                <legend>удалить</legend>-->
<!--                <div class="buttons-block-left">-->
<!--                    <div class="button" id="removecategories">категории</div>-->
<!--                    <div class="button" id="removeproducts">товары</div>-->
<!--                    <div class="button" id="removeprices">цены</div>-->
<!--                </div>-->
<!--            </fieldset>-->
<!---->
<!--            <div class="buttons-block-right">-->
<!--                <div class="button" id="removeall">Удалить все</div>-->
<!--            </div>-->
<!--        </div>-->

        <BR>

        <div class="buttons-block">
        <fieldset>
            <legend>загрузить</legend>
            <div class="buttons-block-left">
                <div class="button" id="loadcategories">категории</div>
                <div class="button" id="loadproducts">товары</div>
                <div class="button" id="loadprices">цены и количество</div>
            </div>
        </fieldset>

            <div class="buttons-block-right">
                <div class="button" id="load">Загрузить все</div>
            </div>
        </div>


        <BR>
        <a class="button"
           title="/adminsc/sync/init?type=catalog&mode=checkauth"
           href="/adminsc/sync/load">type=catalog -- mode=checkauth</a>

        <BR>
        <div class="button" id="">Фильтровать картинки</div>
        <hr>
        <BR>
        <a class="button" href="/adminsc/sync/part?type=catalog&mode=checkauth">/adminsc/sync/part?type=catalog&mode=checkauth</a>
        <a class="button" title="/adminsc/sync/part?type=catalog&mode=import"
           href="/adminsc/sync/part?type=catalog&mode=import">/adminsc/sync/part?type=catalog&mode=import</a>

    </div>

</div>


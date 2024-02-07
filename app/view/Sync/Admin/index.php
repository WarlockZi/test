<?php

use app\core\Icon;

?>
<div class="sync">

	<div class="container files">

		<div dnd data-path="xml"><?= Icon::plus() ?></div>

		<div class="button" id="logshow">Показать содержание лог файла</div>
		<div class="button" id="logclear">Очистить лог файл</div>
		<br>

		<hr>
		<div class="button" id="removeall">Truncate категории, товары, цены</div>
		<br>

		<div class="button" id="loadall">Загрузить</div>
		<br>
		<div id="log_content"></div>
	</div>

	<div class="container">

		<div class="button" id="removecategories">Удалить категории</div>
		<div class="button" id="removeproducts">Удалить товары</div>
		<div class="button" id="removeprices">Удалить цены</div>
		<BR>
		<div class="button" id="loadcategories">Загрузить категории</div>
		<div class="button" id="loadproducts">Загрузить товары</div>
		<div class="button" id="loadprices">Загрузить цены и количество</div>

		<BR>
		<div class="button" id="">Фильтровать картинки</div>
		<BR>
		<BR>
		<a class="button"
		   href="/adminsc/sync/init?type=catalog&mode=import">/adminsc/sync/init?type=catalog&mode=import</a>
		<BR>
		<BR>
		<hr>
		<BR>
		<BR>
		<a class="button" href="/adminsc/sync/part?type=catalog&mode=checkauth">/adminsc/sync/part?type=catalog&mode=checkauth</a>
		<a class="button"
		   href="/adminsc/sync/part?type=catalog&mode=import">/adminsc/sync/part?type=catalog&mode=import</a>

	</div>

</div>


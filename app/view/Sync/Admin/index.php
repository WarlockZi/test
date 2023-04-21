<?php

use app\core\Icon;

?>
<div class="sync">

	<div class="container files">

		<div dnd data-path="xml"><?= Icon::plus() ?></div>

	</div>

	<div class="container">

		<a class="button" href="/adminsc/sync/removeCategories">Удалить категории</a>
		<a class="button" href="/adminsc/sync/removeProducts">Удалить товары</a>
		<a class="button" href="/adminsc/sync/removePrices">Удалить цены</a>
		<BR>
		<a class="button" href="/adminsc/sync/loadCategories">Загрузить категории</a>
		<a class="button" href="/adminsc/sync/loadProducts">Загрузить товары</a>
		<a class="button" href="/adminsc/sync/loadPrices">Загрузить цены и количество</a>

		<BR>
		<a class="button" href="/adminsc/sync/parseImages">Фильтровать картинки</a>
		<BR>
		<BR>
		<a class="button" href="/adminsc/sync/init?type=catalog&mode=import">/adminsc/sync/init?type=catalog&mode=import</a>
		<a class="button" href="/adminsc/sync/incread">incread</a>


	</div>

</div>

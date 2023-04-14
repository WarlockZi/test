<div class="xml">

	<div class="df">


		<div class="container files">

			<div dnd data-path="xml"><?=\app\core\Icon::plus()?></div>

				<? foreach ($files as $file): ?>
			  <p><span class="file">
          <?= basename($file, '.xml'); ?>
					</span>   -
						 <?= filesize($file) / 1000 . ' Kbite'; ?>
			  </p>
				<? endforeach; ?>
		</div>

		<div class="container">

			<form action="xml" method="post">

				<input name="file" type="text">
				<button type="submit" name="action" value="removeCategories">Удалить категории</button>
				<button type="submit" name="action" value="removeProducts">Удалить товары</button>
				<button type="submit" name="action" value="removePrices">Удалить цены</button>
				<BR>
				<button type="submit" name="action" value="loadProducts">Загрузить товары</button>
				<button type="submit" name="action" value="loadProductsOffer">Загрузить товары offer</button>
				<button type="submit" name="action" value="loadCategories">Загрузить категории</button>
				<button type="submit" name="action" value="loadPrices">Загрузить цены</button>

				<button type="submit" name="action" value="parseImages">Фильтровать картинки</button>

			</form>
		</div>
	</div>
</div>

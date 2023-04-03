<div class="xml">

	<div class="flex1">

		<div class="container">
				<? foreach ($files as $file): ?>
			  <p><span class="file">
          <?= basename($file, '.xml'); ?>
					</span> -
						 <?= filesize($file)/1000 . ' Kbite'; ?>
			  </p>
				<? endforeach; ?>
		</div>

		<div class="container">
			<form action="xml" method="post">

				<input name="file" type="text">
				<button type="submit" name="action" value="removeCategories">Удалитьт категории</button>
				<button type="submit" name="action" value="removeProducts">Удалитьт товары</button>
				<button type="submit" name="action" value="removePrices">Удалить цены</button>
				<button type="submit" name="action" value="loadProducts">Загрузить товары</button>
				<button type="submit" name="action" value="loadCategories">Загрузить категории</button>
				<button type="submit" name="action" value="loadPrices">Загрузить цены</button>


			</form>
		</div>
	</div>
</div>

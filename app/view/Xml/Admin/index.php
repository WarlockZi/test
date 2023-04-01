<div class="xml">

	<div class="flex1">

		<div class="container">
      <? foreach ($files as $file): ?>
				<p>
          <?= basename($file, '.xml'); ?> -
          <?= filesize($file).' bite'; ?>
				</p>
      <? endforeach; ?>
		</div>

		<div class="container">
			<form action="xml" method="post">

				<input name="file" type="text">
				<button type="submit" name="action" value="removeCategories">Удалитьт категории</button>
				<button type="submit" name="action" value="removeProducts">Удалитьт товары</button>
				<button type="submit" name="action" value="loadProducts">Загрузить товары</button>
				<button type="submit" name="action" value="loadCategories">Загрузить категории</button>


			</form>
		</div>
	</div>
</div>

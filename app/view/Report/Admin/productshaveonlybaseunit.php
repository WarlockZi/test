<div class="no-main-unit">
	<div class="page-title">
		Товары без основной единицы
	</div>

	<div class="colunm">

		 <? foreach ($productList as $product): ?>
		  <div class="row">

					<?= $product->id; ?>
			  <a href="/adminsc/product/edit/<?= $product->id; ?>"><?= $product->name; ?></a>
		  </div>
		 <? endforeach; ?>
	</div>

</div>

<?php

use app\view\Category\CategoryView;

$promotion = $product->promotions->count() ? "<div class='promotion'>Акция</div>" : '';
?>
<div class="column">
	<?= $promotion ?>
	<a data-instore="<?= $product->instore ?? 0; ?>"

	   href="/product/<?= $product->slug; ?>" class="product">


		<h3 class="name"><?= $product->name; ?></h3>
		 <?= CategoryView::getProductMainImage($product) ?>
		<span class="footer">

					 <p>Цена: <?= $product->instore ? $product->priceWithCurrencyUnit() : 'уточняйте у менеджера'; ?></p>
					 <p>Статус:  <?= !!$product->instore ? "в наличии" : "под заказ"; ?></p>
					 <p>Артикул: <?= $product->art ?? 0; ?></p>

					 </span>
	</a>
	<? if ($admin): ?>
	  <div class="edit">
		  <a href="/adminsc/product/edit/<?= $product->id ?>"><?= $icon ?></a>
	  </div>
	<? endif; ?>

</div>

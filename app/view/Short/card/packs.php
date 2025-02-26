<?php

use app\view\Product\ProductFormView;

?>
<div class="row">
		 <?= ProductFormView::getCardImages('Вид внутритарной упаковки',
			 $product->smallpackImages, 'small-pack'); ?>
	</div>

	<div class="row">
		 <?= ProductFormView::getCardImages('Вид транспортной упаковки',
			 $product->bigpackImages, 'big-pack'); ?>
	</div>

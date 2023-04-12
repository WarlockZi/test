<div class="price">

	<? $price = $product->getRelation('price')->price;
	$oldPrice = number_format($price * 1.1, 2,);
	?>

	<div class="new-price"><?= $price; ?>₽</div>
	<div class="old-price"><?= $oldPrice; ?> ₽</div>

</div>

<div class="button">Добавить в корзину</div>

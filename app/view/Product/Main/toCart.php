<div class="price">

	<? $price = number_format($product->getRelation('price')->price,2,'.', ' ');
	$oldPrice = number_format($price * 1.1, 2,);
	?>

	<div class="new-price"><?= $price; ?> ₽</div>
	<div class="old-price"><?= $oldPrice; ?> ₽</div>

</div>

<div class="button blue">Добавить в корзину</div>

<div class="price">

	<?
	$number = $product->getRelation('price')->price;
	$price = number_format($number,2,'.', ' ');
	$oldPrice = number_format($number * 1.1, 2,);
	?>

	<div class="new-price"><?= $price; ?> ₽</div>
	<div class="old-price"><?= $oldPrice; ?> ₽</div>

</div>

<div class="button blue">Добавить в корзину</div>

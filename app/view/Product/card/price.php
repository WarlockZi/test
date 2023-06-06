<div class="price">

	<?
	$number = $product->getRelation('price')->price;
	$baseUnit = $product->baseUnit->name??'';
	$price = number_format($number, 2, '.', ' ');
	$oldPrice = number_format($number * 1.1, 2,);
	?>

	<div class="new-price"><?= $price; ?> ₽ / <?= $baseUnit; ?> </div>
	<div class="old-price"><?= $oldPrice; ?> ₽</div>

</div>
<div class="price-units ">
	<? foreach ($product->baseUnit->units as $unit): ?>
		<? include __DIR__ . '/priceUnit.php' ?>
	<? endforeach; ?>
</div>

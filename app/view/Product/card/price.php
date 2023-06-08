<div class="price">

	<?
	$priceNumber = $product->getRelation('price')->price??0;
	$baseUnit = $product->baseUnit->name??'';
	$formatedBasePrice = number_format($priceNumber, 2, '.', ' ');
	$formatedOldPrice = number_format($priceNumber * 1.1, 2,);
	?>

	<div class="new-price"><?= $formatedBasePrice; ?> ₽ / <?= $baseUnit; ?> </div>
	<div class="old-price"><?= $formatedOldPrice; ?> ₽</div>

</div>
<div class="price-units ">
	<? foreach ($product->baseUnit->units as $unit): ?>
		<? include __DIR__ . '/priceUnit.php' ?>
	<? endforeach; ?>
</div>

<div class="price-unit-row ">

	<div class="price-for-unit">

		 <? $unitPrice = $unit->pivot->multiplier * (float)$priceNumber; ?>
		 <?= number_format($unitPrice, 2, '.', ' ') ?>
	</div>
	₽ /
	<div class="unit">
		 <?= $unit->name ?>
	</div>

</div>
<?//=var_dump((float)$price)?>
<?//=var_dump($price)?>
<?//=var_dump($unit->pivot->toArray())?>
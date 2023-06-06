<div class="price-unit-row ">

	<div class="price-for-unit">
		 <? $unit_price = $unit->pivot->multiplier * (float)$price; ?>
		 <?= number_format($unit_price, 2, '.', ' ') ?>
	</div>
	₽ /
	<div class="unit">
		 <?= $unit->name ?>
	</div>

</div>
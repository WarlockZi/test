<div class="count-setter">
	<div class="step-field">
		<input type="number" value="<?= $oItem->count; ?>" maxlength="4">

		<span class="input-line"></span>

		<div class="arrow-block ">
			<!--			--><? //include ROOT.'/pic/icons/arrow.svg'?>
			<span class="arrow plus"></span>
			<span class="arrow minus"></span>
		</div>
		 <?
		 $mainUnit = $oItem->product->baseUnit->units
		   ->where('pivot.product_id', $oItem->product['1s_id'])
		   ->where('pivot.main', 1)
		   ->first();
		 if ($mainUnit) {
			 $unitName = $mainUnit->name;
			 $multiplier = $mainUnit->pivot->multiplier;
		 } else {
			 $unitName = $oItem->product->baseUnit->name;
			 $multiplier = 1;
		 }
		 ?>
		<span class="units "><?= $unitName ?></span>
		<input hidden data-multiplier value="<?= $multiplier ?: 1; ?>">
	</div>
</div>
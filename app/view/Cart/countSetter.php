<div class="count-setter">
	<div class="step-field">
		<input type="number" value="<?= $oItem->count; ?>">


        <?= \app\view\Cart\CartView::shippableUnitsSelector($product, $oItem->unit_id); ?>

		<span class="input-line"></span>

		<div class="arrow-block ">
			<span class="arrow plus"></span>
			<span class="arrow minus"></span>
		</div>


	</div>
</div>
<div class="count-setter">
	<div class="step-field">
		<input type="number" value="<?= $oItem->count; ?>" maxlength="4">


        <?= \app\view\Cart\CartView::shippableUnitsSelector($product); ?>

        <input hidden data-multiplier value="<?= $multiplier ?: 1; ?>">
		<span class="input-line"></span>

		<div class="arrow-block ">
			<span class="arrow plus"></span>
			<span class="arrow minus"></span>
		</div>


	</div>
</div>
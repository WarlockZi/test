<? ob_start(); ?>

<div data-field="txt" class="description">

	<div class="detail-text" id="detail-text">
		 <?= $product->txt; ?>
	</div>
	<button id="button" style="width: 100px;">Сохранить</button>
</div>

<? return ob_get_clean(); ?>

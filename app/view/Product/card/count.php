<div class="instore">

	<p>Остаток: <?= number_format($product->instore, 0, '', ' ') ?? 0; ?> <?= $product->baseUnit->name ?? 0; ?></p>

</div>

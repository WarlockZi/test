<?php if ($product): ?>

	<?= $breadcrumbs; ?>
	<?= $product ?>

<?php else: ?>
	<div>Такого товара нет</div>
	<br>
	<a href="/adminsc/category">Перейти в каталог</a>
<?php endif; ?>





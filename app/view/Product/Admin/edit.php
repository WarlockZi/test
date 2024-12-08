<?php if ($order): ?>

	<?= $breadcrumbs; ?>
	<?= $order ?>

<?php else: ?>
	<div>Такого товара нет</div>
	<br>
	<a href="/adminsc/category">Перейти в каталог</a>
<?php endif; ?>





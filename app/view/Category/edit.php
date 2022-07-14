<div class="adm-content">

	<div>

	<a class="button button-outlined" href="/adminsc/category">Все категории</a>
	</div>

	<div class="page-name">Категория: <?= $category['name']; ?></div>
	<div class="products">
		<?foreach ($products as $i=>$product):?>
		<div class="prod"><?=$product['name']?></div>
		<?endforeach;?>

	</div>

</div>
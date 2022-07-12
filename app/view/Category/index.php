<div class="adm-content">

	<div class="page-name">Категория</div>

	<? foreach ($categories as $category): ?>
	  <div class="name">
			 название - <?= $category['name'] ?>
	  </div>

	<? endforeach; ?>
	<?=$accordion;?>

</div>
<main class="vitex-content">

	<?= $breadcrumbs ?? '' ?>

	<h1>Категория - <span><?= $category->name ?? '' ?></span></h1>


	<? if (isset($category) && $category): ?>


		<? if ($category['childrenRecursive']->count()): ?>

		  <div class="category-child-wrap">
					<? foreach ($category['childrenRecursive'] as $child): ?>
				 <a class="category-card" href="/category/<?= $child->slug ?>">
							 <?= $child->name ?>
				 </a>
					<? endforeach; ?>
		  </div>

		<? else: ?>

		  <div class="no-categories">
			  <H1>В категории нет подкатегорий</H1>
		  </div>

		<? endif; ?>

		<? if ($category->products->count()): ?>
		  <div class="product-wrap">

					<? foreach ($category->products as $product): ?>

				 <a href="/product/<?= $product->slug; ?>" class="product">
					 <div class="name">
									<?= $product->name; ?>
					 </div>
							 <? foreach ($product->mainImages as $mainImage): ?>
						<img src="<?= $mainImage->getFullPath() ?>">

							 <? endforeach; ?>
				 </a>
					<? endforeach; ?>
		  </div>

		<? else: ?>
		  <h3>В категории нет товаров</h3>
		<? endif; ?>


	<? else: ?>
	  <div class="no-categories">
		  <H1>Такой категории нет</H1>
	  </div>
	<? endif; ?>

</main>
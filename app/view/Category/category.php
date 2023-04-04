<main class="vitex-content">

	<? if (!$category): ?>
	  <div class="no-categories">
		  <H1>Такой категории нет</H1>
	  </div>
	<? else: ?>

		<?= $breadcrumbs ?? '' ?>

	  <h1>Категория - <span><?= $category->name ?? '' ?></span></h1>


	  <h2>Подкатегории</h2>
		<? if ($category['childrenRecursive']->count()): ?>

		  <div class="category-child-wrap">
					<? foreach ($category['childrenRecursive'] as $child): ?>
				 <a class="category-card" href="/category/<?= $child->slug ?>">
							 <?= $child->name ?>
							 <?= \app\view\Category\CategoryView::getMainImage($child) ?>
				 </a>
					<? endforeach; ?>
		  </div>

		<? else: ?>

		  <div class="no-categories">
			  <p>В категории нет подкатегорий</p>
		  </div>

		<? endif; ?>

		<? if (!$category->products->count()): ?>
		  <h3>В категории нет товаров</h3>
		<? else: ?>

		  <h2>Товары категории</h2>
		  <div class="product-wrap">

					<? foreach ($category->products as $product): ?>

				 <a href="/product/<?= $product->slug; ?>" class="product">
					 <h3 class="name"><?= $product->name; ?></h3>
							 <?= \app\view\Product\ProductView::getMainImage($product) ?>
							 <? if ($product->getRelation('price')) {
								 $price = $product->getRelation('price')->price;
								 $price = bcdiv($price, 1, 2);
								 $currency = $product->getRelation('price')->currency ?? null;
								 $unit = $product->getRelation('price')->unit ?? null;
							 }; ?>
					 <p><?= $price; ?> <?= $currency; ?> / <?= $unit; ?></p>

				 </a>
					<? endforeach; ?>
		  </div>
		<? endif; ?>
	<? endif; ?>

</main>

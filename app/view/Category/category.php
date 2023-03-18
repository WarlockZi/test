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
			  <H2>В категории нет подкатегорий</H2>
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

				 </a>
					<? endforeach; ?>
		  </div>
		<? endif; ?>
	<? endif; ?>

</main>

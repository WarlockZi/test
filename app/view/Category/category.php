<div class="category">

	<? if (!$category): ?>
	  <div class="no-categories">
		  <H1>Такой категории нет</H1>
	  </div>
	<? else: ?>

		<?= $breadcrumbs ?? '' ?>

	  <!--	  <h1>Категория - <span>--><? //= $category->name ?? '' ?><!--</span></h1>-->


		<? if ($category['childrenRecursive']->count()): ?>
		  <h2>Подкатегории</h2>

		  <div class="category-child-wrap">
					<? foreach ($category['childrenRecursive'] as $child): ?>
				 <a class="category-card" href="/category/<?= $child->slug ?>">
							 <?= $child->name ?>
							 <?= \app\view\Category\CategoryView::getMainImage($child) ?>
				 </a>
					<? endforeach; ?>
		  </div>

		<? else: ?>

		  <!--		  <div class="no-categories">-->
		  <!--			  <p>В категории нет подкатегорий</p>-->
		  <!--		  </div>-->

		<? endif; ?>

		<? if (!$category->products->count()): ?>
		  <!--		  <h3>В категории нет товаров</h3>-->
		<? else: ?>

		  <div class="products-header">
			  <h1>Товары</h1>
					<?= $category->products->filters ?>
		  </div>
		  <div class="product-wrap">

					<? foreach ($category->products as $product): ?>
						<?
						$price = $product->getRelation('price')->price ?? 0;
						$currency = $product->getRelation('price')->currency ?? '-';
						$unit = $product->getRelation('price')->unit ?? 'ед';
						?>

				 <a data-instore="<?= $product->instore ?? 0; ?>"
				    data-price="<?= $price; ?>"
				    href="/product/<?= $product->slug; ?>" class="product">
					 <h3 class="name"><?= $product->name; ?></h3>
							 <?= \app\view\Product\ProductView::getMainImage($product) ?>
					 <p><?= $price; ?> <?= $currency; ?> / <?= $unit; ?></p>
					 <p>Остаток - <?= $product->instore ?? 0; ?></p>

				 </a>

					<? endforeach; ?>
		  </div>
		<? endif; ?>
	<? endif; ?>

</div>


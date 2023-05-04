<div class="category">

	<? use app\core\Auth;
	 use app\core\Icon;
	 use app\view\Category\CategoryView;
	use app\view\Product\ProductView;

	if (!isset($category)): ?>
	  <div class="no-categories">
		  <H1>Такой категории нет</H1>
	  </div>
	<? else: ?>

		<?= $breadcrumbs ?? '' ?>

	  <!--	  <h1>Категория - <span>--><? //= $category->name ?? '' ?><!--</span></h1>-->


		<? if ($category['childrenRecursive']->count()): ?>
		  <h1>Подкатегории</h1>

		  <div class="category-child-wrap">
					<? foreach ($category['childrenRecursive'] as $child): ?>
				 <!--						--><? // if ($child->products->count() || $child->childrenRecursive->count()): ?>
				 <a class="category-card" href="/category/<?= $child->slug ?>">
							 <?= $child->name ?>
							 <?= CategoryView::getMainImage($child) ?>
				 </a>

				 <!--						--><? // endif; ?>
					<? endforeach; ?>
		  </div>

		<? else: ?>

		  <!--		  <div class="no-categories">-->
		  <!--			  <p>В категории нет подкатегорий</p>-->
		  <!--		  </div>-->

		<? endif; ?>

		<? if (!$category->products->count()): ?>
		  <!--		  		  <h3>В категории нет товаров</h3>-->
		<? else: ?>

		  <div class="products-header">
			  <h1>Товары</h1>
			  <!--					--><? //= $category->products->filters ?>
		  </div>
		  <div class="product-wrap">

					<? $admin = Auth::isAdmin();
					$icon = Icon::edit(); ?>
					<? foreach ($category->productsInStore as $product): ?>

				 <a data-instore="<?= $product->instore ?? 0; ?>"
				    data-price="<?= $product->getRelation('price')->price ?? 0; ?>"
				    href="/product/<?= $product->slug; ?>" class="product">
					 <h3 class="name"><?= $product->name; ?></h3>
							 <?= ProductView::getMainImage($product) ?>
					 <span class="footer">
					 <p><?= $product->priceWithCurrencyUnit(); ?></p>
					 <p>Остаток - <?= number_format($product->instore, 0, '', ' ') ?? 0; ?> <?= $product->baseUnit->name ?? 0; ?></p>
					 <p>Артикул: <?= $product->art ?? 0; ?></p>

					 </span>
				 </a>
						<? if ($admin): ?>
					 <div class="edit">
						 <a href="/adminsc/product/edit/<?= $product->id ?>"><?= $icon ?></a>
					 </div>
						<? endif; ?>

					<? endforeach; ?>

					<? foreach ($category->productsNotInStore as $product): ?>

				 <a data-instore="<?= $product->instore ?? 0; ?>"
				    data-price="<?= $product->getRelation('price')->price ?? 0; ?>"
				    href="/product/<?= $product->slug; ?>" class="product">
					 <h3 class="name"><?= $product->name; ?></h3>
							 <?= ProductView::getMainImage($product) ?>
					 <span class="footer">
					 <p>Цена: уточнить у менеджера</p>
					 <p>Остаток - <?= number_format($product->instore, 0, '', ' ') ?? 0; ?> <?= $product->baseUnit->name ?? 0; ?></p>
					 <p>Артикул: <?= $product->art ?? 0; ?></p>
					 </span>
				 </a>
						<? if ($admin): ?>
					 <div class="edit">
						 <a href="/adminsc/product/edit/<?= $product->id ?>"><?= $icon ?></a>
					 </div>
						<? endif; ?>

					<? endforeach; ?>

		  </div>
		<? endif; ?>
	<? endif; ?>

</div>


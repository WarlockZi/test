<div class="category">

	<? use app\core\Auth;
	use app\core\Icon;
	use app\view\Category\CategoryView;

	if (!isset($category)): ?>
	  <div class="no-categories">
		  <H1>Такой категории нет</H1>
	  </div>
	<? else: ?>

		<?= $breadcrumbs ?? '' ?>

		<? if ($category['childrenRecursive']->count()): ?>
		  <h1>Подкатегории</h1>

		  <div class="category-child-wrap">
					<? foreach ($category['childrenRecursive'] as $child): ?>
				 <a class="category-card" href="/category/<?= $child->slug ?>">
							 <?= $child->name ?>
					 <!--							 --><? //= CategoryView::getMainImage($child) ?>
				 </a>

					<? endforeach; ?>
		  </div>
		<? endif; ?>

		<? if ($category->productsInStore->count()): ?>

		  <div class="products-header">
			  <h1>Товары в наличии</h1>
			  <!--					--><? //= $category->products->filters ?>
		  </div>

		  <div class="product-wrap">
					<? $admin = Auth::isAdmin();
					$icon = Icon::edit(); ?>

					<? foreach ($category->productsInStore as $product): ?>
						<?= CategoryView::getProductCard($product, $icon) ?>
					<? endforeach; ?>

		  </div>

		<? endif; ?>

		<? if ($category->productsNotInStoreInMatrix->count()): ?>

		  <div class="products-header">
			  <br>
			  <br>
			  <h1>Товары под заказ</h1>
			  <!--					--><? //= $category->products->filters ?>
		  </div>

		  <div class="product-wrap">

					<? $admin = Auth::isAdmin();
					$icon = Icon::edit(); ?>

					<? foreach ($category->productsNotInStoreInMatrix as $product): ?>
						<? if (str_ends_with($product->name,'*')): ?>
							<?= CategoryView::getProductCard($product, $icon) ?>
						<? endif; ?>
					<? endforeach; ?>

		  </div>
		<? endif; ?>
	  <div class="hoist">Наверх</div>
	<? endif; ?>


</div>


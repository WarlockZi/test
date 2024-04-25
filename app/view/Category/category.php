<div class="category">

    <?php use app\core\Auth;
	use app\core\Icon;
	use app\view\Category\CategoryView;

	if (!isset($category)): ?>
	  <div class="no-categories">
		  <H1>Такой категории нет</H1>
	  </div>
    <?php else: ?>

		<?= $breadcrumbs ?? '' ?>

        <?php if ($category['childrenRecursive']->count()): ?>
		  <h1>Подкатегории</h1>

		  <div class="category-child-wrap">
              <?php foreach ($category['childrenRecursive'] as $child): ?>
				 <a class="category-card" href="/category/<?= $child->slug ?>">
							 <?= $child->name ?>
					 <!--							 --><?php //= CategoryView::getMainImage($child) ?>
				 </a>

              <?php endforeach; ?>
		  </div>
        <?php endif; ?>

        <?php if ($category->productsInStore->count()): ?>

		  <div class="products-header">
			  <h1>Товары в наличии</h1>
			  <!--					--><?php //= $category->products->filters ?>
		  </div>

		  <div class="product-wrap">
              <?php $admin = Auth::isAdmin();
					$icon  = Icon::edit(); ?>

              <?php foreach ($category->productsInStore as $product): ?>
						<?= CategoryView::getProductCard($product, $icon) ?>
              <?php endforeach; ?>

		  </div>

        <?php endif; ?>

        <?php if ($category->productsNotInStoreInMatrix->count()): ?>

		  <div class="products-header">
			  <br>
			  <br>
			  <h1>Товары под заказ</h1>
			  <!--					--><?php //= $category->products->filters ?>
		  </div>

		  <div class="product-wrap">

              <?php $admin = Auth::isAdmin();
					$icon  = Icon::edit(); ?>

              <?php foreach ($category->productsNotInStoreInMatrix as $product): ?>
                  <?php if (str_ends_with($product->name,'*')): ?>
							<?= CategoryView::getProductCard($product, $icon) ?>
                  <?php endif; ?>
              <?php endforeach; ?>

		  </div>
        <?php endif; ?>
	  <div class="hoist">Наверх</div>
    <?php endif; ?>


</div>


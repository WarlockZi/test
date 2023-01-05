<main class="vitex-content">

	<?= $breadcrumbs ?? '' ?>

	<h1>Категория - <span><?= $category->name ?? '' ?></span></h1>


	<? if (isset($category) && $category): ?>

	  <!--	<div class="category-wrap">-->
	  <!---->
	  <!--	</div>-->

		<? if ($category['childrenRecursive']->count()): ?>

		  <div class="category-child-wrap">
					<? foreach ($category['childrenRecursive'] as $child): ?>
				 <a class="category-card" href="/category/<?= $child->slug ?>">
							 <?= $child->name ?>
				 </a>
					<? endforeach; ?>
		  </div>

		<? else: ?>

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


			<? endif; ?>


		<? endif; ?>


	  <!--</div>-->
	<? else: ?>
	  <div class="no-categories">
		  <H1>Категорий нет</H1>
	  </div>
	<? endif; ?>

</main>
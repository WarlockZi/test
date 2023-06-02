<h1 class="page-name">Категории</h1>
<div class="category">

	<? use app\view\Category\CategoryView;

	if (isset($categories) && $categories): ?>

	  <div class="category-child-wrap">
			 <? foreach ($categories as $category): ?>
				 <? if ($category): ?>

				 <a class="category-card" href="/category/<?= $category->slug; ?>">
							 <?= $category->name ?>
<!--							 --><?//= CategoryView::getMainImage($category) ?>
				 </a>
				 <? endif; ?>

			 <? endforeach; ?>
	  </div>

	<? else: ?>
	  <div class="no-categories">
		  <H1>Категорий нет</H1>
	  </div>
	<? endif; ?>

</div>
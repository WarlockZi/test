<h1 class="page-name">Категории</h1>
<div class="category">

    <?php

    if (isset($categories) && $categories): ?>

	  <div class="category-child-wrap">
          <?php foreach ($categories as $category): ?>
              <?php if ($category): ?>

				 <a class="category-card" href="/category/<?= $category->slug; ?>">
							 <?= $category->name ?>
<!--							 --><?php //= CategoryView::getMainImage($category) ?>
				 </a>
              <?php endif; ?>

          <?php endforeach; ?>
	  </div>

    <?php else: ?>
	  <div class="no-categories">
		  <H1>Категорий нет</H1>
	  </div>
    <?php endif; ?>

</div>
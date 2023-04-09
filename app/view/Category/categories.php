<main class="vitex-content">

	<h1 class="page-name">Категории</h1>

	<? if (isset($categories) && $categories): ?>

	  <div class="category-wrap">
			 <? foreach ($categories as $category): ?>
				 <? if ($category): ?>

				 <a class="category-card" href="/category/<?= $category->slug; ?>">
							 <?= $category->name ?>
				 </a>
				 <? endif; ?>

			 <? endforeach; ?>
	  </div>

	<? else: ?>
	  <div class="no-categories">
		  <H1>Категорий нет</H1>
	  </div>
	<? endif; ?>

</main>
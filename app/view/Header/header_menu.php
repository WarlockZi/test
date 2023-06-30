<?

use \app\core\Icon;

?>
<div class="header-catalog-menu">

	<div class="header-catalog-menu__wrap">

		 <?= $searchPanel; ?>

		 <? foreach ($frontCategories as $category): ?>
		  <div class='h-cat'><?= $category['name']; ?>
			  <ul>
						 <? if (isset($category->childrenNotDeleted)): ?>
							 <? foreach ($category->childrenNotDeleted as $item): ?>
						 <li>
							 <a href="/category/<?= $item['slug'] ?>"><?= $item['name'] ?></a>
						 </li>
							 <? endforeach; ?>
						 <? endif; ?>
			  </ul>

		  </div>
		 <? endforeach; ?>


		<!--		<div class='h-cat'>Акции-->
		<!--			<ul>-->
		<!--				<li>-->
		<!--					Акций нет. Но скоро будут-->
		<!--				</li>-->
		<!---->
		<!--			</ul>-->
		<!--		</div>-->

		<div class='utils'>
			<div class="search">
					 <?= Icon::search('feather'); ?>
				<div class="search__button"></div>
			</div>

			<a class="cart" href="/cart">
				<div class="count<?= $oItems ? ' show' : ''; ?>"><?= $oItems; ?></div>
					 <?= Icon::shoppingCart('feather'); ?>
			</a>
			<a class="promotions" href="/promotion">
					 <?= Icon::gift(); ?>
			</a>

			<div class="gamburger">
					 <?= Icon::menu('feather') ?>

			</div>

			<div class="mobile-menu">
				<div class="wrap">
					<a href="/main/contacts">Контакты</a>
					<a href="/main/requisites">Реквизиты</a>
					<a href="/main/about">О компании</a>

					<hr>

					<a href="/category">Каталог</a>

				</div>
			</div>
		</div>

	</div>


</div>

<div class="header-catalog-menu">
	<div class="header-catalog-menu__wrap">

		<? foreach ($frontCategories as $mainItem): ?>
			<div class='h-cat'><?= $mainItem['name']; ?>
				<ul>
					<? if (isset($mainItem['children'])): ?>
						<? foreach ($mainItem['children'] as $item): ?>
							<li>
								<a href="/category/<?= $item['slug'] ?>"><?= $item['name'] ?></a>
							</li>
						<? endforeach; ?>
					<? endif; ?>
				</ul>

			</div>
		<? endforeach; ?>


		<div class='h-cat'>Акции
			<ul>
				<li>
					Акций нет. Но скоро будут
				</li>

			</ul>
		</div>

		<div class='utils'>
			<div class="search">
				<? include ICONS . '/feather/search.svg' ?>
                <div class="search__button"></div>
			</div>

			<a class="cart" href="/cart">
				<? include ICONS . '/feather/shoppingCart.svg' ?>
			</a>

			<div class="gamburger">
				<? include ICONS . '/feather/menu.svg' ?>

			</div>

			<div class="mobile-menu">
				<div class="wrap">
					<a href="/about/contacts">Контакты</a>
					<a href="/about/requisites">Реквизиты</a>
					<a href="/main/about">О компании</a>

					<hr>
					<a href="">Акции</a>

					<hr>
					<a href="">Перчатки</a>
					<a href="">Бахилы</a>
					<a href="">Каталог</a>

				</div>
			</div>
		</div>

	</div>

</div>

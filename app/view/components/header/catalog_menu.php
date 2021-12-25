<div class="header-catalog-menu">
	<div class="header-catalog-menu__wrap">

		<? $list = [
			0 => [
				'name' => "Перчатки",
				'childs' => [
					0 => [
						'alias' => 'Нитриловые',
						'name' => 'Нитрил'
					]
				]
			],
			1 => [
				'name' => "Бахилы",
				'childs' => [
					0 => [
						'alias' => 'Прочные',
						'name' => 'Двойные'
					]
				]
			],
			2 => [
				'name' => "Шприцы",
				'childs' => [
					0 => [
						'alias' => 'Эндошприц',
						'name' => 'Эндошприц'
					]
				]
			],
			3 => [
				'name' => "Маски",
				'childs' => [
					0 => [
						'alias' => 'Трехслойные',
						'name' => 'Трехслойные'
					]
				]
			],


		] ?>


		<? foreach ($list as $mainItem): ?>
			<div class='h-cat'><?= $mainItem['name']; ?>
				<ul>
					<? if (isset($mainItem['childs'])): ?>
						<? foreach ($mainItem['childs'] as $item): ?>
							<li>
								<a href="/<?= $item['alias'] ?>"><?= $item['name'] ?></a>
							</li>
						<? endforeach; ?>
					<? endif; ?>
				</ul>

			</div>
		<? endforeach; ?>


		<div class='h-cat'>Акции
			<ul>
				<li>
					<a href="/rasprodazha">распродажа</a>
				</li>

			</ul>
		</div>

		<div class='utils'>
			<div class="search">
				<? include ICONS . '/feather/search.svg' ?>
			</div>

			<a class="cart" href="/cart">
				<? include ICONS . '/feather/shopping-cart.svg' ?>
			</a>

			<div class="gamburger">
				<? include ICONS . '/feather/menu.svg' ?>

			</div>

			<div class="mobile-menu">
				<div class="mobile-menu__wrap">
					<a class="mobile-menu__item" href="/about/contacts">Контакты</a>
					<a class="mobile-menu__item">О компании</a>

					<hr>
					<a class="mobile-menu__item">Акции</a>

					<hr>
					<a class="mobile-menu__item">Перчатки</a>
					<a class="mobile-menu__item">Бахилы</a>
					<a class="mobile-menu__item">Шприцы</a>
					<a class="mobile-menu__item">Маски</a>

				</div>
			</div>
		</div>

	</div>

</div>

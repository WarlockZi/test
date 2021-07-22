<header>


		<div class='h-upper'>

			<? if ($this->route['action'] == "index" && $this->route['controller'] == "Main"): ?>
				<div class="logo">
					<? include_once ROOT . '/app/view/components/header/logo.php'; ?>
				</div>
				<? else: ?>
				<a href='/' class="logo" aria-label='На главную' >
					<? include_once ROOT . '/app/view/components/header/logo.php'; ?>
				</a>
			<? endif; ?>

			<? include_once ROOT . '/app/view/components/header/phone.php' ?>
			<? $this->getSearch('search-header');?>

		</div>


	<div class="header-catalog-menu">
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

	</div>

</header>



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

<!--		--><?// include_once ROOT . '/app/view/components/header/phone.php' ?>
<!--		--><?// $this->getSearch('search-header');?>


	</div>

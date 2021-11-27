<div class='header__info'>

	<? if ($this->route['action'] == "index" && $this->route['controller'] == "Main"): ?>
		<div class="logo">
			<? include ROOT . '/app/view/components/header/logo_desc.php'; ?>
		</div>
	<? else: ?>
		<a href='/' class="logo" aria-label='На главную' >
			<? include ROOT . '/app/view/components/header/logo_desc.php'; ?>
		</a>
	<? endif; ?>

<!--	--><?// include ROOT . '/app/view/components/header/search.php';?>
	<? include ROOT . '/app/view/components/header/phone.php'; ?>


</div>
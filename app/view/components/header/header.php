<div class='header'>

	<?$index=$this->route['action'] == "index" &&$this->route['controller'] == "Main"?>

	<? if ($index): ?>
		<div class="logo">
			<? include ROOT . '/app/view/components/header/logo_plus_desc.php'; ?>
		</div>
	<? else: ?>
		<a href='/' class="logo" aria-label='На главную' >
			<? include ROOT . '/app/view/components/header/logo_plus_desc.php'; ?>
		</a>
	<? endif; ?>


<!--	--><?// include ROOT . '/app/view/components/header/search.php';?>
	<? include ROOT . '/app/view/components/header/phone.php'; ?>
	<? include ROOT . '/app/view/components/header/location.php'; ?>

	<?include ROOT.'/app/view/components/header/user_menu.php'?>

</div>
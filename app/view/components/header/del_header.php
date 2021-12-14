<div class='header'>
	<?$index=$this->route['action'] == "index" &&$this->route['controller'] == "Main"?>

	<? if ($index): ?>
		<div class="logo">
			<? include_once ROOT . '/app/view/components/header/logo_plus_desc.php'; ?>
		</div>
	<? else: ?>
		<a href='/' class="logo" aria-label='На главную'>
			<? include_once ROOT . '/app/view/components/header/logo_plus_desc.php'; ?>
		</a>
	<? endif; ?>


</div>



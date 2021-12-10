<?//=$sidebar;?>
<div class="adm-submenu">

	<? if (in_array('4', $user['rights']) || SU):// SU ?>

		<div class="TEST">TEST</div>

	<? endif; ?>

</div>

<? include ROOT.'/app/view/widgets/sidebar/sidebar.php'?>

<div class="adm-content">
	<div class="breadcrumbs-adm">
		<div>Admin</div>
	</div>
	<div class="clearCache">Очистить кэш</div>

</div>

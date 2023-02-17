<header>

	<div class="info">

		<?=$this->logo;?>

		 <? include ROOT . '/app/view/Header/phone.php'; ?>
		 <? include ROOT . '/app/view/Header/location.php'; ?>
		 <? include ROOT . '/app/view/Header/user_menu.php'; ?>
	</div>

	<div class="menu">
		 <?= $this->frontCategories; ?>
	</div>


</header>

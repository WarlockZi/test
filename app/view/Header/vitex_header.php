<header>

	<div class="info">

		 <? if ($index): ?>
		  <div class="logo">
					<?= $logo; ?>
		  </div>

		 <? else: ?>
		  <a href='/' class="logo" aria-label='На главную'>
					<?= $logo; ?>
		  </a>
		 <? endif; ?>

		 <? include ROOT . '/app/view/Header/phone.php'; ?>
		 <? include ROOT . '/app/view/Header/location.php'; ?>
		 <? include ROOT . '/app/view/Header/user_menu.php'; ?>
	</div>

	<div class="menu">
		 <?= $frontCategories; ?>
	</div>


</header>

<header>

		 <? $index = $controller->route['action'] == "index" && $controller->route['controller'] == "Main" ?>

		 <? if ($index): ?>
		  <div class="logo">
					<? include ROOT . '/app/view/Header/two_logos.php'; ?>
		  </div>
		 <? else: ?>
		  <a href='/' class="logo" aria-label='На главную'>
					<? include ROOT . '/app/view/Header/two_logos.php'; ?>
		  </a>
		 <? endif; ?>


		<!--	--><? // include ROOT . '/app/view/components/header/search.php';?>
		 <? include ROOT . '/app/view/Header/phone.php'; ?>
		 <? include ROOT . '/app/view/Header/location.php'; ?>
		 <? include ROOT . '/app/view/Header/user_menu.php'; ?>



</header>

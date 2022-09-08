<div class="admin-layout_header">
	<a href='/' class="logo" aria-label='На главную'>
	<? include ROOT . '/app/view/components/header/admin/logo_VITEX_grey.php' ?>
	</a>

	<? if (\app\model\User::can($this->user)): ?>
	  <div class="chip-wrap">
		  <a href="/adminsc/user" class="chip">Пользователи</a>
		  <a href="/adminsc/post" class="chip">Должности</a>
		  <a href="/adminsc/test/edit" class="chip">Тесты</a>
		  <a href="/adminsc/opentest/edit" class="chip">Откр Тесты</a>
		  <a href="/adminsc/todo" class="chip">Функции</a>
	  </div>
	<? endif; ?>
	<!--	<a title="Whatsapp" href="whatsapp://send?phone=79814362309"><img src="/pic/WhatsApp.jpg" alt="Написать в Whatsapp" /></a>-->
	<? include ROOT . '/app/view/components/header/user_menu.php' ?>
</div>

<div class="admin-layout__header">
	<? if (\app\model\User::can($this->user)): ?>
	  <div class="chip-wrap">
		  <a href="/adminsc/user/list" class="chip">Пользователи</a>
		  <a href="/adminsc/post/list" class="chip">Должности</a>
		  <a href="/adminsc/test/edit" class="chip">Тесты</a>
		  <a href="/adminsc/opentest/edit" class="chip">Откр Тесты</a>
	  </div>
	<? endif; ?>
	<!--	<a title="Whatsapp" href="whatsapp://send?phone=79814362309"><img src="/pic/WhatsApp.jpg" alt="Написать в Whatsapp" /></a>-->
	<? include_once ROOT . '/app/view/components/header/user_menu.php' ?>
</div>

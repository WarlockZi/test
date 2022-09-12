<? if (!property_exists($controller, 'user')): ?>

	<div class="guest-menu" aria-label="login">
		 <? include ROOT . '/public/src/components/icons/user.svg'; ?>
		Вход
		 <? if (!isset($controller->user)): ?>
		  <ul class="guest-menu__menu">
			  <a href="/auth/login">Войти</a>
			  <a href="/auth/register">Регистрация</a>
			  <a href="/auth/returnpass">Забыл пароль</a>
		  </ul>
		 <? endif; ?>
	</div>


<? else: ?>

	<div class="user-menu">
		<img src="<?= \app\model\User::avatar($controller->user); ?>" alt="">

		<div class="credits">
			<div class="fio"><?= "{$controller->user['surName']} {$controller->user['name']}"; ?></div>
			<div class="email"><?= $controller->user['email']; ?></div>
		</div>

		<div class="menu">
			<a href="/auth/profile">Изменить свой профиль</a>
				<? if (app\model\User::can($controller->user, ['role_employee'])): ?>
			  <a class="list__item" href="/adminsc">Admin</a>
				<? endif; ?>

			<a href="/auth/logout" aria-label="logout">
					 <? include ICONS . "/auth/logout2.svg"; ?>Выход</a>
		</div>
	</div>
<? endif; ?>

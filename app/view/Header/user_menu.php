<? use \app\model\User;

$user = \app\controller\AuthController::user(); ?>
<? if (!$user): ?>

	<div class="guest-menu" aria-label="login">
		 <? include ROOT . '/public/src/components/icons/user.svg'; ?>
		Вход

		  <ul class="guest-menu__menu">
			  <a href="/auth/login">Войти</a>
			  <a href="/auth/register">Регистрация</a>
			  <a href="/auth/returnpass">Забыл пароль</a>
		  </ul>

	</div>

<? else: ?>

	<div class="user-menu">
		<img src="<?= User::avatar($user)??''; ?>" alt="">

		<div class="credits">
			<div class="fio"><?= "{$user['surName']} {$user['name']}"; ?></div>
			<div class="email"><?= $user['email']; ?></div>
		</div>

		<div class="menu">
			<a href="/auth/profile">Изменить свой профиль</a>
				<? if (User::can($user, ['role_employee'])): ?>
			  <a class="list__item" href="/adminsc">Admin</a>
				<? endif; ?>

			<a href="/auth/logout" aria-label="logout">
					 <? include ICONS . "/auth/logout2.svg"; ?>Выход</a>
		</div>
	</div>

<? endif; ?>

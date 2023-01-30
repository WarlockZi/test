<?

use \app\model\User;
use \app\core\Icon;

$user = $controller->user; ?>
<? if (!$user): ?>

	<div class="guest-menu" aria-label="login">
		 <?= Icon::user(); ?>
		Вход

		<ul class="guest-menu__menu">
			<a href="/auth/login">Войти</a>
			<a href="/auth/register">Регистрация</a>
			<a href="/auth/returnpass">Забыл пароль</a>
		</ul>

	</div>

<? else: ?>

	<div class="user-menu">
		<img src="<?= User::avatar($user) ?? ''; ?>" alt="">

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
					 <?= Icon::logout2(); ?>Выход</a>
		</div>
	</div>

<? endif; ?>

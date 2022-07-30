<? if (!isset($this->user)): ?>

	<div class="guest-menu" aria-label="login">
		 <? include ROOT . '/public/src/components/icons/user.svg'; ?>
		Вход
		 <? if (!isset($this->user)): ?>
		  <ul class="guest-menu__menu">
			  <a href="/auth/login">Войти</a>
			  <a href="/auth/register">Регистрация</a>
			  <a href="/auth/returnpass">Забыл пароль</a>
		  </ul>
		 <? endif; ?>
	</div>


<? else: ?>

	<div class="user-menu">
		<img src="<?= \app\model\User::avatar($this->user); ?>" alt="">

		<div class="credits">
			<div class="fio"><?= "{$this->user['surName']} {$this->user['name']}"; ?></div>
			<div class="email"><?= $this->user['email']; ?></div>
		</div>

		<div class="menu">
			<a href="/auth/profile">Изменить свой профиль</a>
				<? if (app\model\User::can($this->user,['role_employee'])): ?>
			  <a class="list__item" href="/adminsc">Admin</a>
				<? endif; ?>

			<a href="/auth/logout" aria-label="logout">
					 <? include ICONS . "/auth/logout2.svg" ?>Выход</a>
		</div>
	</div>
<? endif; ?>

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
		<img src="
        <?= $this->user['sex'] === 'f'
				? $this->getImg('/pic/ava_female.jpg')
				: $this->getImg('/pic/ava_male.png'); ?>
        " alt="">
		<div class="user-menu__credit-wrap">
			<div class="user-menu__fio"><?= "{$this->user['surName']} {$this->user['name']}"; ?></div>
			<div class="user-menu__email"><?= $this->user['email']; ?></div>
		</div>
		<!--        <hr>-->
		<div class="user-menu__menu">
			<a href="/auth/profile">Изменить свой профиль</a>
				<? if (array_intersect(['role_employee'], $this->user['rights']) || defined('SU')): ?>
			  <a class="list__item" href="/adminsc">Admin</a>
				<? endif; ?>

			<a href="/auth/logout" aria-label="logout">
					<? include ICONS . "/auth/logout2.php" ?>Выход</a>
		</div>
	</div>
<? endif; ?>

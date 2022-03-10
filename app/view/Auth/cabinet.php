<section>
	<div class="list">
		<div class="list__header">Личный кабинет</div>
		<a class="list__item" href="/auth/profile">Изменить свой профиль</a>
		<a class="list__item" href="/auth/changepassword">Сменить пароль</a>
		<? if (array_intersect(['role_admin'], $this->user['rights']) || defined('SU')): ?>
			<a class="list__item" href="/adminsc">Admin</a>
		<? endif; ?>
	</div>
</section>



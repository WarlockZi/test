<main>
	<div class="list">
		<div class="list__header">Личный кабинет</div>
		<a class="list__item" href="/auth/profile">Изменить свой профиль</a>
		<a class="list__item" href="/auth/changepassword">Сменить пароль</a>
		<? if ($user->can(['role_admin'])): ?>
			<a class="list__item" href="/adminsc">Admin</a>
		<? endif; ?>
	</div>
</main>



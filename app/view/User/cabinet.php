<section>
	<div class="list">
		<div class="list__header">Личный кабинет</div>
		<a class="list__item" href="/user/edit">Изменить свой профиль</a>
		<a class="list__item" href="/user/changepassword">Сменить пароль</a>
		<? if (in_array('admin', $user['rights']) || SU): ?>
			<a class="list__item" href="/adminsc">Admin</a>
		<? endif; ?>
	</div>
</section>



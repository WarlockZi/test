<section>
	<div class="list">
		<div class="list__header">Личный кабинет</div>

		<a class="list__item" href="/user/edit">Изменить свой профиль</a>
		<? if (in_array('2', $user['rights'])): ?>
			<a class="list__item" href="/user/changepassword">Сменить пароль</a>
		<? endif; ?>

<!--		--><?// if (in_array('1', $user['rights']) || SU): ?>
<!--			<a class="list__item" href="/adminsc/test/edit/1">Редактировать тесты</a></li>-->
<!--		--><?// endif; ?>
<!---->
<!--		--><?// if (in_array('2', $user['rights'])): ?>
<!--			<a class="list__item" href="/test/1">Проходить тесты</a>-->
<!--			<a class="list__item" href="/freetest/1">Проходить свободные тесты</a>-->
<!--		--><?// endif; ?>
		<? if (in_array('employee', $user['rights']) || SU): ?>
			<a class="list__item" href="/adminsc">Admin</a>
		<? endif; ?>
	</div>
</section>



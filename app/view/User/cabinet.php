<section class="container">

	<h3>Личный кабинет</h3>

	<a class="list" href="/user/edit">Изменить свой профиль</a>
	<? if (in_array('2', $user['rights'])): ?>
		<a class="list" href="/user/changepassword">Сменить пароль</a>
	<? endif; ?>

	<?=$user['rights'];?>
	<?=SU;?>

	<? if (in_array('3', $user['rights'])||SU): ?>
		<a class="list" href="/adminsc">Admin</a>
	<? endif; ?>

	<? if (in_array('1', $user['rights'])||SU): ?>
		<a class="list" href="/test/edit/1">Редактировать тесты</a></li>
	<? endif; ?>

	<? if (in_array('2', $user['rights'])): ?>
		<a class="list" href="/test/1">Проходить тесты</a>
		<a class="list" href="/freetest/1">Проходить свободные тесты</a>
	<? endif; ?>

</section>



<? if (!isset($user)): ?>

	<a class="user-menu" href="/user/login" aria-label="login">
<!--		<div class="icon">-->
			<?= include_once ROOT . '/app/view/components/icons/userIcon.php'; ?>
<!--		</div>-->
	</a>

<? else: ?>

<div class="user-menu__FIO">
	<?= "{$user['surName']} {$user['name']}"; ?>

	<div class="nav">
		<a href="/user/edit">Изменить свой профиль</a>
		<a href="/user/cabinet">Личный кабинет</a>
		<?= in_array('1', $user['rights']) ? // редактировать
			'<a href="/test/edit/1">Редактировать тесты</a>
			<a href="/freetest/edit/41">Редактировать свободный тест</a>' : ''
		?>

		<?= in_array('2', $user['rights']) ? // проходить
			'<a href="/test/1">Проходить тесты</a>
			<a href="/freetest/41">Свободный тест</a>' : '';
		?>

		<?= in_array('3', $user['rights'])||SU ?
			'<a href="/adminsc">Admin</a>' : ''; // Admin
		?>


		<a href="/user/logout" aria-label="logout">
				<span class="icon-logout">
					<?= require ROOT . "/app/view/components/icons/logout2.php" ?>
				</span>
			Выход
		</a>
	</div>
	<? endif; ?>

<!DOCTYPE html>
<html>
<!--ADMIN-LAYOUT-->
<head>
	<meta name="token" content="<?= $_SESSION['token'] ?>">
	<meta name="robots" content="noindex,nofollow"/>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="/public/favicon.ico" type="image/x-icon">
	<? $this::getCSS() ?>
	<!--<script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>-->
</head>


<body>
<div class="wrap">
	<header>
		<div class="logo">
			<a href="/">
				<?= require ROOT . '/app/view/components/Logo_small.php'; ?>
			</a>
		</div>



		<div class="user-menu">

                    <span class="FIO"><?
							  $rightId = $user['rights'];
							  if (isset($user)) {
								  echo $user['surName'] . ' ' . $user['name'] . ' ' . $user['middleName'];
							  }
							  ?></span>

			<div class="nav">
				<a href="/user/edit">Редактировать свой профиль</a>
				<? if (in_array('3', $rightId)): ?>
					<a href="/adminsc">Admin</a>
				<? endif; ?>
				<? if (in_array('1', $rightId)): ?>
					<a href="test/edit/1">Ред. закрытые тесты</a>
					<a href="/freetest/edit/41">Ред. открытые тест</a>
				<? endif; ?>
				<? if (in_array('2', $rightId)): ?>
					<a href="/test/1">Закрытый тест</a>
					<a href="/freetest/41">Открытый тест</a>
				<? endif; ?>


				<? if (isset($user)): ?>
					<a href="/test/contacts">
						<span class="icon-envelope">✉ Напишите нам</span>
					</a>

					<a href="/user/logout">
						<?=require_once ROOT. '/app/view/components/logout.php'?>
						Выход</a>
				<? endif; ?>
			</div>


		</div>


	</header>

	<div class="adm-wrap">


		<div class="adm-menu">

			<a href="/adminsc" class="module home"><span>Admin</span></a>
			<a href="/adminsc/catalog" class="module catalog"><span>Каталог</span></a>
			<a href="/adminsc/settings" class="module settings"><span>Настройки</span></a>
			<a href="/adminsc/crm" class="module crm"><span>CRM</span></a>
			<a href="/adminsc/test/edit/1" class="module test"><span>Тестирование</span></a>

		</div>


		<?= $content ?>


	</div>
</div>


<div class="page-buffer"></div>

</div>

<footer></footer>

<div style="display: none">
	<?= include ROOT . '/app/view/components/Logo.php' ?>
</div>

<? $this::getJS() ?>


</body>
</html>
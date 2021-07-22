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

	<header>

		<? include_once ROOT . '/app/view/components/header/admin_top.php'; ?>
		<? include_once ROOT . '/app/view/components/header/admin_header.php'; ?>


	</header>

	<div class="adm-wrap">


		<div class="adm-menu">

			<a href="/adminsc" class="module home"><span>Admin</span></a>
			<a href="/adminsc/catalog" class="module catalog"><span>Каталог</span></a>
			<a href="/adminsc/settings" class="module settings"><span>Настройки</span></a>
			<a href="/adminsc/crm" class="module crm"><span>CRM</span></a>
			<a href="/adminsc/test/edit/1" class="module test"><span>Тесты</span></a>

		</div>


		<?= $content ?>


	</div>



<div class="page-buffer"></div>

</div>

<footer></footer>

<div style="display: none">
	<!--	--><? //= include ROOT . '/app/view/components/icons/logo.php' ?>
</div>

<? $this::getJS() ?>


</body>
</html>
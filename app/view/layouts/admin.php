<!DOCTYPE html>
<html>
<!--ADMIN-LAYOUT-->
<head>
	<meta name="token" content="<?= $_SESSION['token'] ?>">
	<meta name="robots" content="noindex,nofollow"/>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="/public/favicon.ico" type="image/x-icon">
	<!--    <link rel="stylesheet" href="http:localhost:3000/public/dist/admin.css" type="text/css">-->
	<? $this::getCSS() ?>
	<!--<script>document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] + ':35729/livereload.js?snipver=1"></' + 'script>')</script>-->
</head>

<body>


<div class="admin-layout__container">

	<? include ROOT . '/app/view/components/admin_menu/admin_menu__accordion.php'; ?>

  <?= $adminHeader; ?>

	<div class="admin-layout__content">

		 <?= $content ?>

	</div>

	<div class="led"></div>
</div>


<? $this::getJS() ?>


</body>
</html>
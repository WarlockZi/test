<!DOCTYPE html>
<html lang="ru">
<head>
	<!--	empty -layout -->
	<meta charset="utf-8">
	<meta name="token" content="<?= $_SESSION['token'] ?>">
	<meta http-equiv="cleartype" content="on">
	<meta name="MobileOptimized" content="320">
	<meta name="HandheldFriendly" content="True">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<link rel="canonical" href="/<?= isset($vars['canonical']) ? $vars['canonical'] : '' ?>"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="/public/favicon.ico" type="image/x-icon">
	<? $this::getCSS(); ?>

</head>
<body>

		<?= $content ?>

		<? $this::getJS(); ?>

</body>
</html>
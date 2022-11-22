<!DOCTYPE html>
<html lang="ru">
<head>
	<!--	VITEX-LAYOUT-->
	<meta charset="utf-8">
	<meta name="token" content="<?= $_SESSION['token'] ?>">
	<meta http-equiv="cleartype" content="on">
	<meta name="MobileOptimized" content="320">
	<meta name="HandheldFriendly" content="True">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="yandex-verification" content="003253e624aad5b6"/>
	<link rel="canonical" href="/<?= isset($vars['canonical']) ? $vars['canonical'] : '' ?>"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="/public/favicon.ico" type="image/x-icon">
	<? $this::getMeta(); ?>
	<? $this::getCSS(); ?>

</head>

<body>

<?=$header;?>
<?// include ROOT . '/app/view/components/header/vitex_header.php'; ?>

<?=$headerMenu;?>
<?// include ROOT . '/app/view/components/header/catalog_menu.php'; ?>

<?= $content; ?>

<? include ROOT . '/app/view/components/footer/footer.php'; ?>

<? include ROOT . '/app/view/components/footer/cookie.php'; ?>

<? $this::getJS(); ?>
<? //=require_once ROOT.'/app/view/components/ya_metrica.php';?>

</body>
</html>
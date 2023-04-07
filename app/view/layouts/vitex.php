<?
?>

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
	<!--	<link rel="canonical" href="/--><? //= isset($vars['canonical']) ? $vars['canonical'] : '' ?><!--"/>-->
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="/public/favicon.ico" type="image/x-icon">

	<?= $this->assets->getMeta(); ?>
	<?= $this->assets->getCss(); ?>
	<?= $this->assets->getCDNCss(); ?>

</head>

<body>

<?= $this->header->getHeader(); ?>

<div class="user-content">
	<?= $this->getContent(); ?>
</div>

<?= $this->getFooter(); ?>

<? //= Footer::getUserCookie(); ?>

<?= $this->assets->getJs(); ?>
<?= $this->assets->getCDNJs(); ?>
<? //= Footer::getYaMetrica(); ?>
<? //= Footer::getVK(); ?>

</body>
</html>
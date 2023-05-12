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
	<link rel="shortcut icon" href="https://vitexopt.ru/public/favicon.ico" type="image/x-icon">

	<?= $this->assets->getMeta(); ?>
	<?= $this->assets->getCss(); ?>
	<?= $this->assets->getCDNCss(); ?>

</head>

<body>

<?= $this->header->getHeader(); ?>

<div class="relative">
	<main class="user-content">
		 <?= $this->getContent(); ?>
	</main>
</div>

<?= $this->getFooter(); ?>

<? //= Footer::getUserCookie(); ?>

<?= $this->assets->getJs(); ?>
<?= $this->assets->getCDNJs(); ?>
<? //= Footer::getYaMetrica(); ?>
<? //= Footer::getVK(); ?>

<svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
	<circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
	<path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
</svg>

<div class="popup-wrapper">
	<div class="overlay"></div>
	<div class="popup-box">
		<h2></h2>
		<div class="popup-close">x</div>

		<div class="form">
<!--			<input type="text" required name="tel"    placeholder="Сотовый">-->
<!--			<input type="text" required name="fio"    placeholder="Как к вам обращаться">-->
<!--			<input type="text" required name="company" placeholder="Компания">-->
			<p>Оставляя данные вы соглашаетесь с их обработкой</p>
			<button id="submit">Отправить</button>
		</div>

	</div>
</div>

</body>
</html>
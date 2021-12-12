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
<?// include ROOT . '/app/view/components/header/top.php'; ?>
<header>
	<? include ROOT . '/app/view/components/header/logo_phone.php'; ?>
	<? include ROOT . '/app/view/components/header/catalog_menu.php'; ?>
</header>

<?= $content; ?>


<footer>

	<div class="footer_menu">
		<div class="column">
			<a href="/about/contacts" nofollow noindex>Контакты</a>
			<a href="/about/requisites" nofollow noindex>Реквизиты</a>
		</div>
		<div class="column">
			<a href="#">Новости</a>
		</div>
		<div class="column">
			<a href="/about/return_change" nofollow noindex>Возврат и обмен</a>
			<a href="/about/politicaconf" nofollow noindex>Политика конфиденциальности</a>
			<a href="/about/oferta" nofollow noindex>Оферта</a>
		</div>

	</div>
	<div class="footer_legal">
		<p>© <? echo date('Y') ?> Витекс. Цены, указанные на сайте, не являются публичной офертой, определяемой
			положением Статьи 437 (2) ГК РФ и зависят от объема заказа. ОГРН:1173525018292</p>
		<p>Created by VORONIKLAB</p>
	</div>
</footer>


<?= require_once ROOT . '/app/view/components/footer/cookie.php'; ?>
<? $this::getJS(); ?>
<? //=require_once ROOT.'/app/view/components/ya_metrica.php';?>
</body>
</html>
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

<header>
	<div class="top-menu">

		<div class="contacts ">
			<a class="item" href="/about">О НАС</a>
			<a class="item" href="/about/contacts">КОНТАКТЫ</a>
		</div>

		<? if (!isset($user)): ?>

			<a class="user-menu" href="/user/login" aria-label="login">
				<div class="icon">
					<?= require ROOT . '/app/view/components/userIcon.php'; ?>
				</div>
			</a>

		<? else: ?>

		<div class="FIO">
			<?= "{$user['surName']} {$user['name']}"; ?>

			<div class="nav">
				<a href="/user/edit">Редактировать свой профиль</a>
				<?= in_array('1', $user['rights']) ? // редактировать
					'<a href="/test/edit/1">Редактировать тесты</a>
                           <a href="/freetest/edit/41">Редактировать свободный тест</a>' : ''
				?>

				<?= in_array('2', $user['rights']) ? // проходить
					'<a href="/test/1">Проходить тесты</a>
                           <a href="/freetest/41">Свободный тест</a>' : '';
				?>

				<?= in_array('3', $user['rights']) ?
					'<a href="/adminsc">Admin</a>' : ''; // Admin
				?>


				<a href="/user/logout" aria-label="logout">
				<span class="icon-logout">
					<?= require ROOT . "/app/view/components/logout2.php" ?>
				</span>
					Выход
				</a>
			</div>

			<? endif; ?>

		</div>

	</div>
	<div class="inner-wrap">
		<div class='h-upper'>
			<div class="logo-wrap">
				<?= (!($this->route['action'] == "index" && $this->route['controller'] == "Main")) ? "<a href = '/' aria-label = 'На главную'></a>" : "" ?>
				<?= $this::getLogo() ?>
				<span class="logo-desc">Медицинские расходные <br>материалы оптом</span>
			</div>
			<? if (!'Test' == $this->route['controller']): ?>
				<div class='phone-wrap'>
					<div class='icon-phone'>
						<a href="tel:+79217131767">8 (921) 713-17-67</a>
						<div class="popup-info">
							<div class="inner">
								<div class="head">Время работы 8:30 – 17.30 по Москве</div>
								<p>Дополнительные телефоны:</p>
								<p class="phones">
									<a href="tel:+78172217762">8 (8172) 21-77-62</a><br>
									<a href="tel:+79095942911">8 (909) 594-29-11</a></p>
								<p></p>
							</div>
						</div>
					</div>
				</div>

				<div class="search-wrap">
					<input id="autocomplete" type="text" placeholder="Поиск" name="q" value="" size="20"
					       maxlength="50" class="form-text" autocomplete="off" aria-label="поиск">
					<span id="btnSrch" class="find"></span>
					<div class="result-search"></div>
				</div>
			<? endif; ?>


		</div>

		<div class="header-lower row">
			<? foreach ($list as $mainItem): ?>
				<div class='h-cat'><?= $mainItem['name']; ?>
					<ul>
						<? if (isset($mainItem['childs'])): ?>
							<? foreach ($mainItem['childs'] as $item): ?>
								<li>
									<a href="/<?= $item['alias'] ?>"><?= $item['name'] ?></a>
								</li>
							<? endforeach; ?>
						<? endif; ?>
					</ul>

				</div>
			<? endforeach; ?>


			<div class='h-cat'>Акции
				<ul>
					<li>
						<a href="/inventar">Скидка</a>
					</li>
					<li>
						<a href="/rasprodazha">распродажа</a>
					</li>

				</ul>
			</div>

		</div>

	</div>
</header>

<?= $content ?>


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


<div id="cookie-notice" role="banner">Продолжая использовать сайт, вы даете согласие на обработку файлов cookie,
	пользовательских данных (сведения о местоположении; тип и версия ОС; тип и версия Браузера; тип устройства и
	разрешение его экрана; источник откуда пришел на сайт пользователь; с какого сайта или по какой рекламе;
	язык ОС и Браузера; какие страницы открывает и на какие кнопки нажимает пользователь; ip-адрес) в целях
	функционирования сайта, проведения ретаргетинга и проведения статистических исследований и обзоров. Если вы
	не хотите, чтобы ваши данные обрабатывались, покиньте сайт.
	<span id="cn-accept-cookie" onclick="return setCookie(this);">Соглашаюсь</span>
</div>


<!--</div>-->
<? $this::getJS(); ?>

<!--</div>-->
<!-- Yandex.Metrika counter -->
<!--<script defer>-->
<!--    (function (m, e, t, r, i, k, a) {-->
<!--        m[i] = m[i] || function () {-->
<!--            (m[i].a = m[i].a || []).push(arguments)-->
<!--        };-->
<!--        m[i].l = 1 * new Date();-->
<!--        k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a)-->
<!--    })-->
<!--    (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");-->
<!---->
<!--    ym(7715905, "init", {-->
<!--        clickmap: true,-->
<!--        trackLinks: true,-->
<!--        accurateTrackBounce: true,-->
<!--        webvisor: true-->
<!--    });-->
<!--</script>-->
<!--<noscript>-->
<!--	<div><img src="https://mc.yandex.ru/watch/7715905" style="position:absolute; left:-9999px;" alt=""/></div>-->
<!--</noscript>-->
<!-- /Yandex.Metrika counter -->
</body>
</html>
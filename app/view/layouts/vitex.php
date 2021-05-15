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

<div class="site-wrapper">
	<input name="toggle-button" type="checkbox" id="toggle-button">
	<label id="toggle-label" for="toggle-button">☰</label>

	<nav id="menu" class="transition">
		<div class="menu-wrap column">
			<a class="item" href="/perchatki-rezinovye-tekhnicheskie">перчатки</a>
			<a class="item" href="/about/payment">бахилы</a>
			<a class="item" href="/about/payment">сиз</a>
			<a class="item" href="/about/payment">шприцы</a>
			<hr>
			<a class="item" href="/about/payment">акции</a>
			<a class="item" href="/about/payment">ОПЛАТА</a>
			<a class="item" href="/about/delivery">ДОСТАВКА</a>
			<a class="item" href="/about/return_change">ВОЗВРАТ И ОБМЕН</a>
			<a class="item" href="/about/discount">СИСТЕМА СКИДОК</a>
			<a class="item" href="/about/contacts">Контакты</a>


			<div class="item">СТАТЬИ</div>
			<a href="/about/contact-us">
				<span class="icon-envelope">✉</span>
				Напишите нам
			</a>
		</div>
	</nav>

	<div id="panel">


		<div class="top-menu">
			<div class="row">

				<div class="contacts ">
					<a class="item" href="/about">О НАС</a>
					<a class="item" href="/about/contacts">КОНТАКТЫ</a>
				</div>

				<div class="user-menu ">
                <span class="row">
                    <? if (!isset($user)): ?>
	                    <a href="/user/login" aria-label="login">

                       <span class="icon">
	                       <svg xmlns="http://www.w3.org/2000/svg" focusable="false" data-icon="user" role="img">
	                         <symbol id='user' viewBox="0 0 490 490">
		                       <path fill="currentColor"
		                             d="M313.6 304c-28.7 0-42.5 16-89.6 16-47.1 0-60.8-16-89.6-16C60.2 304 0 364.2 0 438.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-25.6c0-74.2-60.2-134.4-134.4-134.4zM400 464H48v-25.6c0-47.6 38.8-86.4 86.4-86.4 14.6 0 38.3 16 89.6 16 51.7 0 74.9-16 89.6-16 47.6 0 86.4 38.8 86.4 86.4V464zM224 288c79.5 0 144-64.5 144-144S303.5 0 224 0 80 64.5 80 144s64.5 144 144 144zm0-240c52.9 0 96 43.1 96 96s-43.1 96-96 96-96-43.1-96-96 43.1-96 96-96z"/>
	                         </symbol>
		                       <use xlink:href="#user" width="100%" height="100%"/>
	                       </svg>
                       </span>

                     </a>
						  <? else: ?>
                     <?if (isset($user)) {
								  echo '<span class = "FIO">' . $user['surName'] . ' ' . $user['name'] . ' ' . $user['middleName'] . '</span>';
							  } ?>




	                    <div class="nav">
                       <a href="/user/edit">Редактировать свой профиль</a>
                       <?=
							  in_array('1', $user['rights']) ? // редактировать
								  '<a href="/test/edit/1">Редактировать тесты</a>
                      <a href="/freetest/edit/41">Редактировать свободный тест</a>' : ''
							  ?>

								  <?=
								  in_array('2', $user['rights']) ? // проходить
									  '<a href="/test/1">Проходить тесты</a>
                      <a href="/freetest/41">Свободный тест</a>' : '';
								  ?>

								  <?=
								  in_array('3', $user['rights']) ?
									  '<a href="/adminsc">Admin</a>' : ''; // Admin
								  ?>

								  <? if (isset($user)): ?>
			                    <a href="/user/logout" aria-label="logout">
                            <span class="icon-logout">
                              <svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="16" height="20"
                                   viewBox="0 0 20 20">
                              <path fill='#e30000'
                                    d="M4 8v-2c0-3.314 2.686-6 6-6s6 2.686 6 6v0h-3v2h4c1.105 0 2 0.895 2 2v0 8c0 1.105-0.895 2-2 2v0h-14c-1.105 0-2-0.895-2-2v0-8c0-1.1 0.9-2 2-2h1zM9 14.73v2.27h2v-2.27c0.602-0.352 1-0.996 1-1.732 0-1.105-0.895-2-2-2s-2 0.895-2 2c0 0.736 0.398 1.38 0.991 1.727l0.009 0.005zM7 6v2h6v-2c0-1.657-1.343-3-3-3s-3 1.343-3 3v0z"></path>
                              </svg>
                            </span>
                            Выход
                          </a>
								  <? endif; ?>
                     </div>
						  <? endif; ?>

                </span>
				</div>


			</div>
		</div>

		<header>
			<div class="inner-wrap">
				<div class='h-upper'>
					<div class="logo-wrap">
						<?= (!($this->route['action'] == "index" && $this->route['controller'] == "Main")) ? "<a href = '/' aria-label = 'На главную'></a>" : "" ?>
						<?=$this::getLogo()?>
						<span class="logo-desc">Медицинские расходные <br>материалы оптом</span>
					</div>

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
						       maxlength="50" class="form-text" autocomplete="off" aria-label="поиск"
						">
						<span id="btnSrch" class="find"></span>

						<div class="result-search"></div>

					</div>

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
								<a href="/inventar">инвентарь</a>
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


		<? $this::getJS(); ?>

	</div>
</div>
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
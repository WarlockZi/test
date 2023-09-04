<!DOCTYPE html>
<html lang="ru">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>bot99</title>
	<?=$assets->getCss()?>
	<?=$assets->getJs()?>

</head>

<body>
<div class="container">

	<header>
		<div class="elipse">
			<input class="elipse-input" id="elipse-input" type="checkbox">
			<label class="elipse-label" for="elipse-input"></label>
			<nav class="nav">
				<ul>

					<li class="nav-item">
						<a href="#">Голосовые боты</a>
					</li>
					<li class="nav-item">
						<a href="#">Чат боты</a>
					</li>
					<li class="nav-item">
						<a href="#">Интеграция с CRM</a>
					</li>
				</ul>

			</nav>
		</div>

	</header>

	<main>
		<section class="slogan">
			<div class="slogan-overlay"></div>
			<div class="slogan-article-wrap">

				<article class="slogan-article">

					<h1 class="slogan-h1">
						Автоматизируй свой <span class="slogan-blue">бизнес</span>
					</h1>
					<p class="slogan-p">Автоматизируем продажи с помощью голосовых и чат ботов c различными CRM
						системами </p>

					<div class="slogan-butns">
						<button class="button blue-button">Связаться</button>
						<button class="button grey-button">Узнать больше</button>
					</div>

				</article>
				<div class="slogan-article-space"></div>
			</div>

		</section>

		<section class="advantages section">
			<div class="section-content">

				<h2 class="main-h2">
					Автоматизация бизнеса экономит до 90% расходов компании и приносит больше денег
				</h2>
				<p class="advantage-call">Чтобы начать автоматизацию, интеграцию и внедрение нового продукта c
					голосовыми роботами, обратитесь к
					профессионалам.
				</p>

				<div class="advantage-services">
					<article class="advantage-article">
						<svg class="advantage-svg" width="30px" viewBox="0 0 640 512" fill="white" stroke="white"
						     xmlns="http://www.w3.org/2000/svg">
							<path
									d="M0 256v128c0 17.7 14.3 32 32 32h32V224H32c-17.7 0-32 14.3-32 32zM464 96H352V32c0-17.7-14.3-32-32-32s-32 14.3-32 32v64H176c-44.2 0-80 35.8-80 80v272c0 35.3 28.7 64 64 64h320c35.3 0 64-28.7 64-64V176c0-44.2-35.8-80-80-80zM256 416h-64v-32h64v32zm-32-120c-22.1 0-40-17.9-40-40s17.9-40 40-40 40 17.9 40 40-17.9 40-40 40zm128 120h-64v-32h64v32zm96 0h-64v-32h64v32zm-32-120c-22.1 0-40-17.9-40-40s17.9-40 40-40 40 17.9 40 40-17.9 40-40 40zm192-72h-32v192h32c17.7 0 32-14.3 32-32V256c0-17.7-14.3-32-32-32z">
							</path>
						</svg>
						<div class="advantage-text">
							<h3 class="main-h3">Автоматизация</h3>
							<p class="advantage-p">Получите полный комплекс услуг по автоматизации процессов вашей
								организации c голосовыми роботами</p>
						</div>
					</article>

					<article class="advantage-article">
						<svg class="advantage-svg" width="30px" viewBox="0 0 8 8" fill="currentColor"
						     xmlns="http://www.w3.org/2000/svg">
							<path
									d="M1 0l-1 1 1.5 1.5-1.5 1.5h4v-4l-1.5 1.5-1.5-1.5zm3 4v4l1.5-1.5 1.5 1.5 1-1-1.5-1.5 1.5-1.5h-4z">
							</path>
						</svg>
						<div class="advantage-text">
							<h3 class="main-h3">Интеграция</h3>
							<p class="advantage-p">Мы помогаем интегрировать голосового бота и внешнее ПО и сервисы между
								собой</p>
						</div>
					</article>

					<article class="advantage-article">
						<svg class="advantage-svg" width="30px" viewBox="0 0 8 8" fill="currentColor"
						     xmlns="http://www.w3.org/2000/svg">
							<path
									d="M.34 0a.5.5 0 0 0-.34.5v5a.5.5 0 0 0 .5.5h2.5v1h-1c-.55 0-1 .45-1 1h6c0-.55-.45-1-1-1h-1v-1h2.5a.5.5 0 0 0 .5-.5v-5a.5.5 0 0 0-.5-.5h-7a.5.5 0 0 0-.09 0 .5.5 0 0 0-.06 0zm.66 1h6v4h-6v-4z">
							</path>
						</svg>
						<div class="advantage-text">
							<h3 class="main-h3">Внедрение</h3>
							<p class="advantage-p">Мы внедрим наши решения и настроим всё для лёгкой и безопасной
								работы</p>
						</div>
					</article>
				</div>

			</div>
		</section>

		<section class="services section">
			<div class="section-wrap">

				<h2 class="main-h2">Услуги</h2>

				<div class="cards-wrap">

					<article class="card">
						<h3 class="main-h3">
							Лидогенерация
						</h3>
						<p class="services">Массовый обзвон клиентов</p>
						<a class="services-link" href="/bot/leadgen">Подробнее</a>
					</article>

					<article class="card">
						<h3 class="main-h3">
							NPS
						</h3>
						<p class="services">Оценка качества сервиса</p>
						<a class="services-link" href="/bot/nps">Подробнее</a>
					</article>

					<article class="card">
						<h3 class="main-h3">
							Входящие звонки
						</h3>
						<p class="services">Клиенты звонят круглосуточно</p>
						<a class="services-link" href="/bot/leadgen">Подробнее</a>
					</article>

					<article class="card">
						<h3 class="main-h3">
							Исходящие звонки
						</h3>
						<p class="services">Если не хватает свободных рук или сотрудников</p>
						<a class="services-link" href="/bot/leadgen">Подробнее</a>
					</article>

					<article class="card">
						<h3 class="main-h3">
							Ответы на частые вопросы
						</h3>
						<p class="services">Устали отвечать на одни и те же вопросы</p>
						<a class="services-link" href="/bot/leadgen">Подробнее</a>
					</article>

					<article class="card">
						<h3 class="main-h3">
							Игровые механики
						</h3>
						<p class="services">Люди всегда любили играть. </p>
						<a class="services-link" href="/bot/leadgen" title="" >Подробнее</a>
					</article>


				</div>
			</div>
		</section>

		<section class="problems section">
			<div class="section-wrap">

				<h2 class="main-h2 about-h2">Решим ваши проблемы</h2>

				<div class="cards-wrap">

					<article class="card">
						<h3 class="card-header">
							Администратор не отрабатывает возражения
						</h3>
						<audio class="problems-audio" controls>
							<source src="/public/src/bot/audio/manager.mp3" type="audio/mp3">
						</audio>
					</article>

					<article class="card">
						<h3 class="card-header">
							Администратор бросает трубку
						</h3>
						<audio class="problems-audio" controls>
							<source src="/public/src/bot/audio/manager.mp3" type="audio/mp3">
						</audio>
					</article>

					<article class="card">
						<h3 class="card-header">
							Администратор не обучен
						</h3>
						<audio class="problems-audio" controls>
							<source src="/public/src/bot/audio/manager.mp3" type="audio/mp3">
						</audio>
					</article>

				</div>
			</div>
		</section>

		<section class="about-us section">
			<div class="section-wrap">
				<div class="about-us-wrap">
					<div class="about-us-img-wrap">
						<img class="about-us-img" src="/public/src/bot/img/main/ввв-прозрачный.png" alt="Вороник Виталий" loading="lazy">
					</div>
					<div class="about-us-text">
						<h2 class="main-h2 about-h2">
							Кто мы такие
						</h2>
						<p class="main-p">Меня зовут Вороник Виталий и я основатель компании "Bot99", где мы с
							командой помогаем бизнесу разрабатывать интегрировать и автоматизировать процессы с помощью ботов.</p>
						<p class="main-p">Основная наша цель заключается в знаменитой фразе «Вкалывают роботы, а не
							человек».</p>
						<p class="main-p">Поэтому мы на 100% сосредоточены на том, чтобы заменить большинство
							операций средствами автоматизации, освободить ваш бизнес от рутины и сэкономить деньги.</p>
						<p class="main-p">Мы сами являемся разработчиками ПО, а также официальными партнёрами
							большинства сервисов и поставщиков ПО для бизнеса.</p>
						<p class="main-p">Сделайте следующий шаг с нами и вы увидите, как растёт ваша выручка,
							расходы сокращаются, а число ошибок (тот самый человеческий фактор) стремиться к нулю.</p>
					</div>
				</div>
			</div>
		</section>

		<section class="connect section">
			<div class="connect-wrap">
				<p class="connect-p">Свяжитесь с нами прямо сейчас</p>
				<button class="button blue-button connect-button">Связаться</button>
			</div>
		</section>

		<section class="faq section">
			<div class="section-wrap">

				<h2 class="main-h2">Ответы на вопросы</h2>

				<ul class="accordeon faq-accordeon">

					<li class="accordeon-item">
						<button class="accordeon-btn accordeon-btn-grey">
							<span class="accordeon-title">Каким образом происходит работа?</span>
							<span class="accordeon-trigger"></span>
						</button>

						<div class="accordeon-item-content">
							<p>Работа начинается после предварительно составленного технического задания и
								проработки сметы. В техническом задании прописываются контрольные этапы,
								методы
								тестирования и проверки, формат технического взаимодействия и прочие
								существенные детали.</p>
							<p>После согласования технического задания происходит этап разработки и
								внедрения.
								На контрольных точках мы сверяемся с техническим заданием и если нужно
								корректируем его.</p>
							<p>В результате вы получаете готовую систему, которая работает для вас.</p>
						</div>
					</li>

					<li class="accordeon-item">
						<button class="accordeon-btn accordeon-btn-grey">
							<span class="accordeon-title">Какими сервисами автоматизации мы пользуемся?</span>
							<span class="accordeon-trigger"></span>
						</button>

						<div class="accordeon-item-content">
							<p>Для автоматизации мы можем использовать no code и RPA сервисы, где с минимальными
								знаниями в программировании создаём систему взаимодействия между техническими
								элементами автоматизируемой системы.</p>
							<p>Если же готовых решений не достаточно, до пишем своё решение, которое позволит на
								100% закрыть ваши задачи.</p>
						</div>
					</li>


					<li class="accordeon-item">
						<button class="accordeon-btn accordeon-btn-grey">
							<span class="accordeon-title">Занимаетесь-ли вы разработкой ПО на заказ?</span>
							<span class="accordeon-trigger"></span>
						</button>

						<div class="accordeon-item-content">
							<p>Да, но исключительно в рамках нашей специализации по автоматизации
								бизнес-процессов на голосовых ботах.</p>
						</div>
					</li>

					<li class="accordeon-item">
						<button class="accordeon-btn accordeon-btn-grey">
							<span class="accordeon-title">На каких языках программирования вы работаете?</span>
							<span class="accordeon-trigger"></span>
						</button>

						<div class="accordeon-item-content">
							<p>Наш основной язык программирования в разработке PHP и MySQL в качестве БД. В
								исключительных случаях мы можем привлекать специалистов в других областях, но
								это оговаривается отдельно в техническом задании.</p>
							<p>Наш основной framework для разработки — Laravel</p>
						</div>
					</li>

					<li class="accordeon-item">
						<button class="accordeon-btn accordeon-btn-grey">
                                <span class="accordeon-title">Обязательно-ли работать с
                                    Laravel?</span>
							<span class="accordeon-trigger"></span>
						</button>

						<div class="accordeon-item-content">
							<p>Мы работаем с Laravel по одной причине: это самая популярная система разработки
								сайтов в мире с открытым исходным кодом.</p>
							<p>Разработчики Laravel не имеют права закрывать исходный код от других. Это
								значит, что вы видите с какими кодами имеете дело.</p>
							<p>Кроме того, у нас собрана одна из лучших русскоязычных команд в этой сфере.</p>
							<p>Поэтому если вы работаете с нами, то Laravel обязателен для связок
								автоматизации и интеграции. При этом ваш сайт может работать на чём угодно. На
								нашу работу это не влияет никак.</p>
						</div>
					</li>

					<li class="accordeon-item">
						<button class="accordeon-btn accordeon-btn-grey">
                                <span class="accordeon-title">Есть-ли какие-то гарантии с вашей
                                    стороны?</span>
							<span class="accordeon-trigger"></span>
						</button>

						<div class="accordeon-item-content">
							<p>Да, мы гарантируем результат в рамках технического задания. В случае если мы не
								можем решить задачу, Вы просто получите назад свои деньги без каких-либо
								вопросов.</p>
						</div>
					</li>


				</ul>

			</div>
		</section>

		<section class="bottom section">
			<div class="bottom-wrap section-wrap column">
				<h2 class="main-h2">Автоматизируйте свой бизнес сегодня</h2>
				<p class="main-p bottom-p">Для этого свяжитесь с нами и мы начнём нашу работу.</p>
				<button class="button blue-button">Связаться c нами</button>
			</div>

		</section>

	</main>

	<footer class="footer">
		© 2023 ИП Вороник Виталий Викторович ИНН 253523642447
	</footer>

</div>
</body>

</html>
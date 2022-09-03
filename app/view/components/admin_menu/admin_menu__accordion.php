<? use \app\model\User; ?>
<div class="admin_sidebar">

	<? include ICONS . '/gamburger.svg' ?>
<!--	<a class="logo" href="/">-->
<!--		 --><?// include ROOT . '/app/view/components/header/admin/logo_VITEX_white.php' ?>
<!--		<span class="logo_square"></span>-->
<!--	</a>-->

	<div accordion>

		<a class="house neon" href="/adminsc">
				<? include ICONS . '/admin-menu/house.svg' ?>
			Главная
		</a>

		 <? if (User::can($this->user, ['gate_admin', 'role_rop'])): // admin ?>
		  <li crm>

			  <div class="label">

				  <div class="arrow"></div>
						 <? include ICONS . '/admin-menu/chart.svg'; ?>

				  CRM

			  </div>
			  <ul class="level-1">
				  <a class="neon" href="/adminsc/order">Заказы</a>
				  <a class="neon" href="/adminsc/user/list">Пользователи</a>
				  <a class="neon" href="/adminsc/crm">crm</a>
			  </ul>
		  </li>
		 <? endif; ?>


		 <? if (User::can($this->user, ['role_admin', 'role_rop'])): // admin ?>
		  <li settings>

			  <div class="label">
				  <span class="arrow"></span>
						 <? include ICONS . '/admin-menu/settings-streamline.svg'; ?>
				  Настройки
			  </div>

			  <ul class="level-1">
						 <? if (User::can($this->user, ['gate_admin'])): // admin ?>
					 <a class="neon" href='/adminsc/property'>Свойства</a>
					 <a class="neon" href='/adminsc/right/list'>Права</a>
					 <a class="neon" href='/adminsc/tag'>Tэги</a>
					 <a class="neon" href='/adminsc/image'>Картинки</a>
					 <a class="neon" href='/adminsc/post'>Должности</a>
					 <a class="neon" href='/adminsc/todo/list'>Задачи</a>
						 <? endif; ?>
			  </ul>
		  </li>
		 <? endif; ?>

		 <? if (User::can($this->user, ['role_employee'])): // admin ?>
		  <li video>

			  <div class="label">
				  <span class="arrow"></span>
						 <? include ICONS . '/youtube.svg'; ?>
				  Видео
			  </div>

			  <ul class="level-1">
				  <a class="neon" href='/adminsc/videoinstruction'>Инструкции</a>
				  <a class="neon" href='/adminsc/videoinstruction/edit'>Редактировать инструкции</a>

			  </ul>
		  </li>
		 <? endif; ?>

		<li test>
			<div class="label">
				<span class="arrow"></span>
					 <? include ICONS . '/admin-menu/star.svg'; ?>
				Тесты
			</div>
			<ul class="level-1">

					 <? if (User::can($this->user, ['role_employee'])): ?>
				  <a class="neon" href="/adminsc/test/do">Проходить тесты</a>
					 <? endif; ?>

					 <? if (User::can($this->user, ['role_admin'])): ?>
				  <a class="neon" href="/adminsc/test/edit">Редактировать тесты</a>
					 <? endif; ?>

					 <? if (User::can($this->user, ['role_admin'])): ?>
				  <a class="neon" href="/adminsc/testresult">Результаты тестов </a>
					 <? endif; ?>

					 <? if (User::can($this->user, ['role_employee'])): ?>
				  <a class="neon" href="/adminsc/opentest/do">Проходить открытые тесты</a>
					 <? endif; ?>

					 <? if (User::can($this->user, ['role_admin'])): ?>
				  <a class="neon" href="/adminsc/opentest/edit">Редактировать открытые тесты</a>
					 <? endif; ?>

					 <? if (User::can($this->user, ['role_admin'])): ?>
				  <a class="neon" href="/adminsc/opentestresult">Результаты открытых тестов </a>
					 <? endif; ?>

			</ul>
		</li>

		<li plan>
			<div class="label">
				<span class="arrow"></span>
					 <? include ICONS . '/admin-menu/target.svg'; ?>
				Планирование
			</div>
			<ul class="level-1">
					 <? if (User::can($this->user, 'role_employee')): // admin ?>
				  <a class="neon" href="/adminsc/planning/create">Создать задачи</a>
				  <a class="neon" href="/adminsc/planning/list">Посмотреть планировки</a>
				  <a class="neon" href="/adminsc/planning/plan">Спланироваться</a>
				  <a class="neon" href="/adminsc/cicles/">Циклограмма</a>
					 <? endif; ?>
			</ul>
		</li>

		<a strat class="neon" href="/adminsc/planning">
				<? include ICONS . '/admin-menu/grid.svg'; ?>
			<span>
		Страт задачи
		</span>
		</a>

		<li catalog>
			<div class="label">
				<span class="arrow"></span>
					 <? include ICONS . '/feather/shopping-cart.svg'; ?>
				Каталог
			</div>
			<ul class="level-1">
					 <? if (User::can($this->user, 'role_admin')): // admin ?>
				  <a class="neon" href="/adminsc/category">Категории</a>
				  <a class="neon" href="/adminsc/product/list">Товары</a>

					 <? endif; ?>
			</ul>
		</li>

		<li user>
			<div class="label">
				<span class="arrow"></span>
					 <? include ICONS . '/admin-menu/user-check.svg'; ?>
				Пользователь
			</div>
			<ul class="level-1">
					 <? if (User::can($this->user, 'role_employee')): // admin ?>
				  <a class="neon" href="/auth/returnpass">Забыл пароль</a>
				  <a class="neon" href="/auth/changepassword">Сменить пароль</a>
				  <a class="neon" href="/auth/profile">Изменить свой профиль</a>

					 <? endif; ?>
			</ul>
		</li>


		 <? if (User::can($this->user, 'su')): ?>
		  <li su>

			  <div class="label">
				  <span class="arrow"></span>
						 <? include ICONS . '/admin-menu/aperture.svg'; ?>
				  SU
			  </div>
			  <ul class="level-1">
				  <a class="neon" href='/adminsc/Sitemap'>Создать SiteMap</a>
				  <a class="neon" href='/adminsc/settings/dump'>Dump</a>
				  <a class="neon" href='/adminsc/settings/props'>Свойства (товаров, пользователей)</a>
				  <a class="neon" href='/adminsc/settings/pics'>Картинки</a>
				  <a class="neon" href='/adminsc/settings/cache'>Очистить кэш</a>
			  </ul>
		  </li>
		 <? endif; ?>

		<li class="admin_sidebar-tail"></li>


	</div>


</div>

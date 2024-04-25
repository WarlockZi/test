<?

use \app\model\User;
use \app\core\Icon;
use \app\view\Accordion\Admin\SidebarBuilder;

?>
<?//=
//SidebarBuilder::build($user)
//	->class('sidebar')
//	->item(
//		[
//			'header' => ['title' => 'CRM', 'icon' => 'chart', 'arrow' => 'arrow'],
//			'rights' => ['role_admin', 'role_manager'],
//			'ul' => [
//				["/adminsc/wish", "Предложения сайт"],
//				["/adminsc/order", "Заказы"],
//				["/adminsc/user", "Пользователи"],
//				["/adminsc/crm", "crm"],
//				["/adminsc/promotion", "Акции"],
//			]
//		],
//		)
//	->get();
//?>

<ul class="admin_sidebar">

	<li class="admin_sidebar_header">

		 <?= Icon::gamburger() ?>

		 <? include ROOT . '/app/view/Header/templates/user_credits.php' ?>

	</li>



	<ul accordion>
		<li>
			<a class="house neon" href="/adminsc">
					 <?= Icon::house('admin-menu') ?>

				Главная
			</a>
		</li>

		 <? if (User::can($user, ['role_admin', 'role_manager'])): ?>
		  <li>
			  <div class="label">
				  <div class="arrow"></div>
						 <?= Icon::chart('admin-menu') ?>
				  CRM
			  </div>
			  <ul class="level-1">
				  <a class="neon" href="/adminsc/wish">Предложения сайт</a>
				  <a class="neon" href="/adminsc/order">Заказы</a>
				  <a class="neon" href="/adminsc/user">Пользователи</a>
				  <a class="neon" href="/adminsc/crm">crm</a>
				  <a class="neon" href="/adminsc/promotion">Акции</a>
			  </ul>
		  </li>
		 <? endif; ?>


		 <? if (User::can($user, ['role_admin'])): // admin ?>
		  <li>

			  <div class="label">
				  <span class="arrow"></span>
						 <?= Icon::settingsStreamline('admin-menu') ?>
				  Настройки
			  </div>

			  <ul class="level-1">
						 <? if (User::can($user, ['role_admin'])): // admin ?>
					 <a class="neon" href='/adminsc/property'>Свойства</a>
					 <a class="neon" href='/adminsc/right'>Права</a>
					 <a class="neon" href='/adminsc/country'>Страны</a>
					 <a class="neon" href='/adminsc/manufacturer'>Производители</a>
					 <a class="neon" href='/adminsc/tag'>Tэги</a>
					 <a class="neon" href='/adminsc/unit'>Ед. измерен.</a>
					 <a class="neon" href='/adminsc/image'>Картинки</a>
					 <a class="neon" href='/adminsc/post'>Должности</a>
					 <a class="neon" href='/adminsc/todo'>Задачи</a>
						 <? endif; ?>
			  </ul>
		  </li>
		 <? endif; ?>

		 <? if (User::can($user, ['role_employee'])): // admin ?>
		  <li>

			  <div class="label">
				  <span class="arrow"></span>
						 <?= Icon::youtube() ?>
				  Видео
			  </div>

			  <ul class="level-1">
				  <a class="neon" href='/adminsc/videoinstruction'>Инструкции</a>
						 <? if (User::can($user, ['role_admin'])): ?>
					 <a class="neon" href='/adminsc/videoinstruction/edit'>Редактировать инструкции</a>
						 <? endif; ?>
			  </ul>
		  </li>
		 <? endif; ?>

		<li>
			<div class="label">
				<span class="arrow"></span>
					 <?= Icon::star('admin-menu') ?>
				Тесты
			</div>
			<ul class="level-1">

					 <? if (User::can($user, ['role_employee'])): ?>
				  <a class="neon" href="/adminsc/test/do">Проходить тесты</a>
					 <? endif; ?>

					 <? if (User::can($user, ['role_admin'])): ?>
				  <a class="neon" href="/adminsc/test/edit">Редактировать тесты</a>
					 <? endif; ?>

					 <? if (User::can($user, ['role_admin'])): ?>
				  <a class="neon" href="/adminsc/testresult">Результаты тестов </a>
					 <? endif; ?>

					 <? if (User::can($user, ['role_employee'])): ?>
				  <a class="neon" href="/adminsc/opentest/do">Проходить открытые тесты</a>
					 <? endif; ?>

					 <? if (User::can($user, ['role_admin'])): ?>
				  <a class="neon" href="/adminsc/opentest/edit">Редактировать открытые тесты</a>
					 <? endif; ?>

					 <? if (User::can($user, ['role_admin'])): ?>
				  <a class="neon" href="/adminsc/opentestresult">Результаты открытых тестов </a>
					 <? endif; ?>

			</ul>
		</li>

		<li>
			<div class="label">
				<span class="arrow"></span>
					 <?= Icon::flag('admin-menu') ?>
				Планирование
			</div>
			<ul class="level-1">
					 <? if (User::can($user, ['role_employee'])): // admin ?>
				  <a class="neon" href="/adminsc/planning/create">Создать задачи</a>
				  <a class="neon" href="/adminsc/planning/list">Посмотреть планировки</a>
				  <a class="neon" href="/adminsc/planning/plan">Спланироваться</a>
				  <a class="neon" href="/adminsc/cicles/">Циклограмма</a>
					 <? endif; ?>
			</ul>
		</li>

		<li class="reports">
			<div class="label">
				<span class="arrow"></span>
					 <?= Icon::target('admin-menu') ?>
				Отчеты
			</div>
			<ul class="level-1">
					 <? if (User::can($user, ['role_admin'])): // admin ?>

				  <a class="neon" href="/adminsc/report/productsNoImgInstore">Товары без картинок в наличии</a>
				  <a class="neon" href="/adminsc/report/productsNoImgNotinstore">Товары без картинок без наличия</a>

				  <a class="neon" href="/adminsc/report/productsNoMinimumUnit">Товары без min единицы</a>
				  <a class="neon" href="/adminsc/report/productsNoDopUnit" title="Нужны для корзины, чтобы ">Товары без доп единиц</a>
                         <a class="neon" href="/adminsc/report/productsHaveDopUnit" title="Нужны для корзины, чтобы ">Товары имеющие доп единицу</a>
					 <? endif; ?>
			</ul>
		</li>

		<a strat class="neon" href="/adminsc/planning">
				<?= Icon::grid('admin-menu') ?>
			<span>
		Страт задачи
		</span>
		</a>

		<li>
			<div class="label">
				<span class="arrow"></span>
					 <?= Icon::shoppingCart('feather') ?>

				Каталог
			</div>
			<ul class="level-1">
					 <? if (User::can($user, ['role_admin'])): // admin ?>
				  <a class="neon" href="/adminsc/category">Категории</a>
				  <a class="neon" href="/adminsc/product/list">Товары</a>
				  <a class="neon" href="/adminsc/product/trashed">Товары удалены</a>
				  <a class="neon" href="/adminsc/productfilter">Фильтр по товарам</a>

					 <? endif; ?>
			</ul>
		</li>

		<!--		<li logistic>-->
		<!--			<div class="label">-->
		<!--				<span class="arrow"></span>-->
		<!--					 --><? //= Icon::shoppingCart('feather') ?>
		<!---->
		<!--				Логистика-->
		<!--			</div>-->
		<!---->
		<!--		</li>-->

		<li>
			<div class="label">
				<span class="arrow"></span>
					 <?= Icon::userCheck('admin-menu') ?>
				Пользователь
			</div>
			<ul class="level-1">
					 <? if (User::can($user, ['role_employee'])): // admin ?>
				  <a class="neon" href="/auth/returnpass">Забыл пароль</a>
				  <a class="neon" href="/auth/changepassword">Сменить пароль</a>
				  <a class="neon" href="/auth/profile">Изменить свой профиль</a>
				  <a class="neon" href="/auth/logout">Выйти</a>

					 <? endif; ?>
			</ul>
		</li>


		 <? if (User::can($user)): ?>
		  <li>

			  <div class="label">
				  <span class="arrow"></span>
						 <?= Icon::aperture('admin-menu') ?>
				  SU
			  </div>
			  <ul class="level-1">

				  <a class="neon" href="/adminsc/logistic">Логистика</a>
				  <a class="neon" href="/adminsc/settings/list">Настройки</a>
				  <a class="neon" href='/adminsc/Sitemap'>Создать SiteMap</a>
				  <a class="neon" href='/adminsc/settings/dump'>Dump</a>
				  <a class="neon" href='/adminsc/settings/props'>Свойства (товаров, пользователей)</a>
				  <a class="neon" href='/adminsc/settings/cache'>Очистить кэш</a>
				  <a class="neon" href="/adminsc/sync">1c Sync</a>
				  <a class="neon" href="/adminsc/request">Запросы</a>
				  <a class="neon" href="/adminsc/request/phpinfo/">PHPinfo</a>
				  <a class="neon" href="/adminsc/request/test/">test</a>
			  </ul>
		  </li>
		 <? endif; ?>

		<li class="admin_sidebar-tail"></li>


	</ul>


</ul>

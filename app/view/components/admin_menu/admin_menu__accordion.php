<? use \app\model\User; ?>
<ul class="admin-layout__sidebar accordion">

	<a class="admin-sidebar__logo" href="/">
		 <? include ROOT . '/app/view/components/header/admin/logo_VITEX_white.php' ?>
	</a>

	<a class="house neon" href="/adminsc">
		 <? include ICONS . '/admin-menu/house.svg' ?>
		Главная
	</a>

	<? if (User::can($this->user, ['gate_admin', 'role_rop'])): // admin ?>
	  <li>
		  <input type="checkbox" id="crm">
		  <label for="crm">
					<? include ICONS . '/admin-menu/user-check.svg'; ?>
			  CRM
		  </label>
		  <ul>
			  <a class="neon" href="/adminsc/order/list">Заказы</a>
			  <a class="neon" href="/adminsc/user/list">Пользователи</a>
			  <a class="neon" href="/adminsc/crm">crm</a>
		  </ul>
	  </li>
	<? endif; ?>


	<? if (User::can($this->user, ['role_admin', 'role_rop'])): // admin ?>
	  <li>
		  <input type="checkbox" id="settings">
		  <label for="settings">
					<? include ICONS . '/admin-menu/settings-streamline.svg'; ?>
			  Настройки
		  </label>

		  <ul>
					<? if (User::can($this->user, ['gate_admin'])): // admin ?>
				 <a class="neon" href='/adminsc/right/list'>Права</a>
				 <a class="neon" href='/adminsc/post/list'>Должности</a>
				 <a class="neon" href='/adminsc/todo/list'>Задачи</a>
					<? endif; ?>
		  </ul>
	  </li>
	<? endif; ?>

	<li>
		<input type="checkbox" id="test">
		<label for="test">
				<? include ICONS . '/admin-menu/star.svg'; ?>
			Тесты
		</label>
		<ul>

				<? if (User::can($this->user, ['role_employee'])):  ?>
			  <a class="neon" href="/adminsc/test/do">Проходить открытые тесты</a>
			  <a class="neon" href="/adminsc/opentest/do">Проходить тесты</a>
				<? endif; ?>
				<? if (User::can($this->user, ['opentest-edit_read'])): ?>
			  <a class="neon" href="/adminsc/opentest/edit">Редактировать открытые тесты</a>
				<? endif; ?>
				<? if (User::can($this->user, ['test-edit_read'])):  ?>
			  <a class="neon" href="/adminsc/test/edit">Редактировать тесты</a>
				<? endif; ?>
				<? if (User::can($this->user, ['test-results_read'])): ?>
			  <a class="neon" href="/adminsc/testresult/results">Результаты тестов </a>
				<? endif; ?>
		</ul>
	</li>

	<li>
		<input type="checkbox" id="planning">
		<label for="planning">
				<? include ICONS . '/admin-menu/target.svg'; ?>
			Планирование
		</label>
		<ul>
				<? if (User::can($this->user, 'role_employee')): // admin ?>
			  <a class="neon" href="/adminsc/planning/create">Создать задачи</a>
			  <a class="neon" href="/adminsc/planning/list">Посмотреть планировки</a>
			  <a class="neon" href="/adminsc/planning/plan">Спланироваться</a>
			  <a class="neon" href="/adminsc/cicles/">Циклограмма</a>
				<? endif; ?>
		</ul>
	</li>

	<a class="neon" href="/adminsc/planning">
		 <? include ICONS . '/admin-menu/grid.svg'; ?>
		Страт задачи
	</a>

	<? if (User::can($this->user, 'su')): ?>
	  <li>
		  <input type="checkbox" id="su">
		  <label for="su">
					<? include ICONS . '/admin-menu/aperture.svg'; ?>
			  SU
		  </label>
		  <ul>
			  <a class="neon" href='/adminsc/Sitemap'>Создать SiteMap</a>
			  <a class="neon" href='/adminsc/settings/dump'>Dump</a>
			  <a class="neon" href='/adminsc/settings/props'>Свойства (товаров, пользователей)</a>
			  <a class="neon" href='/adminsc/settings/pics'>Картинки</a>
			  <a class="neon" href='/adminsc/settings/cache'>Очистить кэш</a>
		  </ul>
	  </li>
	<? endif; ?>

	<li class="admin-layout__sidebar-tail"></li>


</ul>

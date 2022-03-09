<ul class="admin-layout__sidebar accordion">
	<a class="admin-sidebar__logo" href="/">
		 <? include ROOT . '/app/view/components/header/admin/logo_VITEX_white.php' ?>
	</a>

	<a class="house neon" href="/adminsc">
		 <? include ICONS . '/admin-menu/house.svg' ?>
		Главная
	</a>

	<? if (array_intersect(['gate_admin', 'role_rop'], $this->user['rights'])||defined('SU')): // admin ?>
	  <li>
		  <input type="checkbox" id="crm">
		  <label for="crm">
					<? include ICONS . '/admin-menu/user-check.svg'; ?>
			  CRM
		  </label>
		  <ul>
			  <a data-id="1" class=" neon" href="/adminsc/crm/orders">Заказы</a>
			  <a data-id="1" class=" neon" href="/adminsc/user/list">Пользователи</a>
			  <a data-id="1" class=" neon" href="/adminsc/crm">crm</a>
		  </ul>
	  </li>
	<? endif; ?>


	<? if (array_intersect(['gate_settings', 'role_rop','su'], $this->user['rights'])||defined('SU')): // admin ?>
	  <li>
		  <input type="checkbox" id="settings">
		  <label for="settings">
					<? include ICONS . '/admin-menu/settings-streamline.svg'; ?>
			  Настройки
		  </label>

		  <ul>
					<? if (array_intersect(['gate_admin'], $this->user['rights'])||defined('SU')): // admin ?>
				 <a class=" neon" href='/adminsc/Sitemap'>Создать SiteMap</a>
				 <a class=" neon" href='/adminsc/settings/dump'>Dump</a>
				 <a class=" neon" href='/adminsc/settings/props'>Свойства (товаров, пользователей)</a>
				 <a class=" neon" href='/adminsc/settings/pics'>Картинки</a>
				 <a class=" neon" href='/adminsc/settings/cache'>Очистить кэш</a>
				 <a class=" neon" href='/adminsc/rights'>Права</a>
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
				<? if (array_intersect(['test-do_read', 'role_employee'], $this->user['rights'])): // admin ?>
			  <a class=" neon" href="/test/do">Проходить тесты</a>
				<? endif; ?>
				<? if (in_array('test-edit_read', $this->user['rights'])): // admin ?>
			  <a class=" neon" href="/adminsc/test/edit">Редактировать тесты</a>
				<? endif; ?>
				<? if (in_array('test-results_read', $this->user['rights'])): // admin ?>
			  <a class=" neon" href="/adminsc/crm/testresults">Результаты тестов </a>
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
				<? if (in_array('test-do_read', $this->user['rights'])||defined('SU')): // admin ?>
			  <a class=" neon" href="/adminsc/planning/create">Создать задачи</a>
				<? endif; ?>
				<? if (in_array('test-edit_read', $this->user['rights'])||defined('SU')): // admin ?>
			  <a class=" neon" href="/adminsc/planning/list">Посмотреть планировки</a>
				<? endif; ?>
				<? if (in_array('test-results_read', $this->user['rights'])||defined('SU')): // admin ?>
			  <a class=" neon" href="/adminsc/planning/user">Спланироваться</a>
				<? endif; ?>
		</ul>
	</li>

	<a class="sidebar__main neon" href="/adminsc/planning">
		 <? include ICONS . '/admin-menu/grid.svg'; ?>
		Страт задачи
	</a>

	<li class="admin-layout__sidebar-tail"></li>


</ul>

<ul class="admin-layout__sidebar accordion">

    <?include ROOT.'/app/view/components/header/logo_VITEX_white.php'?>


    <a data-id="8" class="level1 neon" href="/adminsc">Главная</a>
    <i class="fa fa-house-user"></i>

	<li class="has-children level1">
		<input type="checkbox" id="crm">
		<label for="crm">CRM</label>
		<ul>
				<a data-id="1" class="level2 neon" href="/adminsc/crm/orders">
                    Заказы</a>
				<a data-id="1" class="level2 neon" href="/adminsc/crm/users">Пользователи</a>
				<a data-id="1" class="level2 neon" href="/adminsc/crm">crm</a>
		</ul>
	</li>

	<li class="has-children level1">
		<input type="checkbox" id="settings">
		<label for="settings">Настройки</label>

		<ul>
				<a data-id="2" class="level2 neon" href  = '/adminsc/Sitemap'>Создать SiteMap</a>
				<a data-id="3" class="level2 neon" href  = '/adminsc/settings/dump'>Dump</a>
				<a data-id="6" class="level2 neon" href  = '/adminsc/settings/props'>Свойства (товаров, пользователей)</a>
				<a data-id="9" class="level2 neon" href  = '/adminsc/settings/pics'>Картинки</a>
		</ul>
	</li>
	<li class="has-children level1">
		<input type="checkbox" id="test">
		<label for="test">Тесты</label>
		<ul>
				<a class="level2 neon" href="/test/do">Проходить тесты
<!--				<span class="sub">dd</span>-->
<!--				<span class="sub">ss</span>-->
				</a>
				<a class="level2 neon" href="/adminsc/test/edit">Редактировать тесты</a>
				<a data-id="10" class="level2" href="/adminsc/crm/testresults">Результаты тестов </a>
		</ul>
	</li>
    <li class="admin-layout__sidebar-tail"></li>


</ul>

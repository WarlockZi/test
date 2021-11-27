<? if (in_array('3', $user['rights'])||SU): // admin ?>
	<div class="admin-actions">

		<a href  = "crm/orders">Заказы</a>
		<a href  = 'crm/users'>Покупатели</a>
		<a href  = '/adminsc/crm/testresults'>Результаты тестов</a>

	</div>
<? endif; ?>

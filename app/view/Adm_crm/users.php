<div class="adm-content">

	<? use app\view\components\CustomList\CustomList; ?>
	<? return new CustomList(
		[
			'model' => $users,
			'tableClassName' => 'users',
			'columns' => [
				'id' => [
					'className' => 'id',
					'name' => 'ID',
					'width' => '50px',
					'sort' => true,
					'search' => false,
				],
				'fio' => [
					'className' => 'fio',
					'concat'=>['surName','name','middleName',],
					'name' => 'фио',
					'width' => '1fr',
					'sort' => true,
					'search' => true,
				],
				'email' => [
					'className' => 'email',
					'name' => 'email',
					'width' => '1fr',
					'sort' => true,
					'search' => true,
				],
			  'co' => [
					'className' => 'email',
					'name' => 'co',
					'width' => '50px',
					'sort' => true,
					'search' => false,
				],
			],
			'editCol' => true,
			'delCol' => true,
		]
	) ?>

<!--	<div class="custom-list users">-->
<!---->
<!--		<th class="id">ID</th>-->
<!--		<th class="fio">фио<input type="text"></th>-->
<!--		<th class="email">email<input type="text"></th>-->
<!--		<th class="confirmed">co</th>-->
<!--		<th class="edit">--><?// include EDIT; ?><!--</th>-->
<!--		<th class="del">--><?// include TRASH; ?><!--</th>-->
<!---->
<!--		 --><?// foreach ($users as $use): ?>
<!---->
<!--		  <td class="id">--><?//= $use['id'] ?><!--</td>-->
<!--		  <td>-->
<!--			  <a class="fio" href="/adminsc/crm/user?id=--><?//= $use['id']; ?><!--">-->
<!--						 --><?//= $use['surName']; ?><!-- --><?//= $use['name']; ?><!-- --><?//= $use['middleName']; ?>
<!--			  </a>-->
<!--		  </td>-->
<!--		  <td class="email">--><?//= $use['email']; ?><!--</td>-->
<!--		  <td class="confirmed">--><?//= $use['confirm']; ?><!--</td>-->
<!---->
<!--		  <td class="edit">-->
<!--			  <a href="/adminsc/crm/user?id=--><?//= $use['id']; ?><!--">-->
<!--						 --><?// include EDIT; ?>
<!--			  </a>-->
<!--		  </td>-->
<!---->
<!--		  <td class="del">-->
<!--			  <a href="/adminsc/crm/user/delete?id=--><?//= $use['id']; ?><!--">-->
<!--						 --><?// include TRASH; ?>
<!--			  </a>-->
<!--		  </td>-->
<!---->
<!--		 --><?// endforeach; ?>
<!---->
<!---->
<!--	</div>-->


</div>

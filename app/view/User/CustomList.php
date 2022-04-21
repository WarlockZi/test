<?php

use app\view\components\CustomList\CustomList;


$t = new CustomList(
	[
		'models' => $users,
		'modelName' => "user",
		'tableClassName' => 'users',
		'addButton'=>'ajax',
		'columns' => [
			'id' => [
				'className' => 'id',
//				'field' => 'id',
				'name' => 'ID',
				'width' => '50px',
				'sort' => true,
				'search' => false,
			],
			'fio' => [
				'className' => 'fio',
				'field' => '',
				'concat' => ['surName', 'name', 'middleName',],
				'name' => 'фио',
				'width' => '1fr',
				'sort' => true,
				'search' => true,
			],
			'email' => [
				'className' => 'email',
				'field' => 'email',
				'name' => 'email',
				'width' => '1fr',
				'sort' => true,
				'search' => true,
			],
			'co' => [
				'className' => 'co',
				'field' => 'confirm',
				'name' => 'co',
				'width' => '50px',
				'sort' => true,
				'search' => false,
			],
		],
		'editCol' => true,
		'delCol' => true,
	]
);


return $t->html;




<?php
use app\view\components\CustomList\CustomList;

$list =  new CustomList(
	[
		'models' => $items,
		'modelName' => $this->modelName,
		'tableClassName' => $this->tableName,
		'columns' => [
			'id' => [
				'className' => 'id',
				'field' => 'id',
				'name' => 'ID',
				'width' => '50px',
				'data-type' => 'number',
				'sort' => true,
				'search' => false,
			],

			'name' => [
				'className' => 'name',
				'field' => 'name',
				'name' => 'Наименование',
				'width' => '1fr',
				'contenteditable' => 'contenteditable',
				'data-type' => 'string',
				'sort' => true,
				'search' => true,
			],
			'full_name' => [
				'className' => 'fullname',
				'field' => 'full_name',
				'name' => 'Полное наименование',
				'width' => '1fr',
				'contenteditable' => 'contenteditable',
				'data-type' => 'string',
				'sort' => true,
				'search' => true,
			],
		],

		'editCol' => true,
//				'delCol' => false,
		'delCol' => 'ajax',
		'addButton' => 'ajax',//'redirect'
	]
);
return $list->html;


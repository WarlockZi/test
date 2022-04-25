<?php
use app\view\components\CustomCatalogItem\CustomCatalogItem;

$item = new CustomCatalogItem(
	[
		'item' => $item,
		'modelName' => $this->modelName,
		'tableClassName' => $this->tableName,
		'fields' => [
			'id' => [
				'className' => 'id',
				'field' => 'id',
				'name' => 'ID',
				'contenteditable' => '',
				'width' => '50px',
				'data-type' => 'number',
			],
			'name' => [
				'className' => 'name',
				'field' => 'name',
				'name' => 'Наименование',
				'width' => '1fr',
				'contenteditable' => 'contenteditable',
				'data-type' => 'string',
			],
			'full_name' => [
				'className' => 'fullname',
				'field' => 'full_name',
				'name' => 'Полное наименование',
				'width' => '1fr',
				'contenteditable' => 'contenteditable',
				'data-type' => 'string',
			],
			'chief' => [
				'className' => 'chief',
				'field' => 'chief',
				'name' => 'Подчиняется',
				'width' => '1fr',
				'contenteditable' => false,
				'data-type' => 'multiselect',
				'select' => $chiefs,
			],
			'subourdinate' => [
				'className' => 'fullname',
				'field' => '$subordinate',
				'name' => 'Управляет',
				'width' => '1fr',
				'data-type' => 'multiselect',
				'select' => $subordinates,
			],
		],

		'delBttn' => 'ajax',
		'toListBttn' => true,
		'saveBttn' => 'ajax',//'redirect'
	]
);
return $item->html;
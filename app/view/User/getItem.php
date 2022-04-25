<?php
use app\view\components\CustomCatalogItem\CustomCatalogItem;
use \app\view\components\CustomSelect\CustomSelect;
use \app\view\components\CustomMultiSelect\CustomMultiSelect;


$confirm = new CustomSelect([
	'selectClassName' => 'custom-select',
	'title' => '',
	'field' => 'enable',
	'tab' => '&nbsp;&nbsp;&nbsp;',
	'initialOption' => true,
	'initialOptionValue' => '---',
	'nameFieldName' => 'test_name',
	'tree' => [0 => 'да', 1 => 'нет'],
	'selected' => ['0'],
]);
$confirm = $confirm->html;

$rights = new CustomMultiSelect([
	'selectClassName' => 'custom-select',
	'title' => '',
	'field' => 'rights',
	'tab' => '&nbsp;&nbsp;&nbsp;',
	'initialOption' => true,
	'initialOptionValue' => '---',
	'nameFieldName' => 'name',
	'fieldName' => 'name',
	'tree' => $rights,
	'selected' => $user['rights'],
]);
$rights = $rights->html;

$t = new CustomCatalogItem([

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
				'surName' => [
					'className' => 'fullname',
					'field' => 'full_name',
					'name' => 'Полное наименование',
					'width' => '1fr',
					'contenteditable' => 'contenteditable',
					'data-type' => 'string',
				],
				'Подтвержден' => [
					'className' => 'confirm',
					'field' => 'confirm',
					'name' => 'confirm',
					'width' => '50px',
					'contenteditable' => false,
					'data-type' => 'select',
					'select' => $confirm,
				],
				'rights' => [
					'className' => 'rights',
					'field' => 'rights',
					'name' => 'Права',
					'width' => '1fr',
					'data-type' => 'select',
					'select' => $rights,
				],

			],

			'delBttn' => 'ajax',
			'toListBttn' => true,
			'saveBttn' => 'ajax',//'redirect'





]);
return $t->html;
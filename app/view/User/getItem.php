<?php
use app\view\components\CustomCatalogItem\CustomCatalogItem;
use \app\view\components\CustomSelect\CustomSelect;
use \app\view\components\CustomRadio\CustomRadio;
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

$sex = new CustomRadio([
//		private $fieldName = '';

	'className' => 'custom-radio',
	'title' => '',
	'field' => 'sex',
	'nameFieldName' => 'test_name',
	'tree' => ['m'=>'М','f'=>'Ж'],
	'selected' => 'm',
]);
$sex = $sex->html;

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
					'data-type' => 'number',
				],
				'surName' => [
					'className' => 'surName',
					'field' => 'surName',
					'name' => 'Фамилия',
					'contenteditable' => 'contenteditable',
					'data-type' => 'string',
				],

				'Подтвержден' => [
//					'field' => 'confirm',
					'name' => 'Подтвержден',
					'contenteditable' => false,
					'data-type' => 'select',
					'select' => $confirm,
				],
				'name' => [
					'className' => 'name',
					'field' => 'name',
					'name' => 'Имя',
					'contenteditable' => 'contenteditable',
					'data-type' => 'string',
				],
				'middleName' => [
					'className' => 'middleName',
					'field' => 'middleName',
					'name' => 'Отчестово',
					'contenteditable' => 'contenteditable',
					'data-type' => 'string',
				],

				'email' => [
					'className' => 'email',
					'field' => 'email',
					'name' => 'email',
					'contenteditable' => false,
					'data-type' => 'string',
				],

				'phone' => [
					'className' => 'phone',
					'field' => 'phone',
					'name' => 'Рабочий сотовый',
					'contenteditable' => 'contenteditable',
					'data-type' => 'string',
				],

				'birthDate' => [
					'className' => 'bday',
					'field' => 'birthDate',
					'name' => 'День рождения',
					'contenteditable' => true,
					'data-type' => 'date',
				],

				'sex' => [
					'className' => 'sex',
					'field' => 'sex',
					'name' => 'Пол',
					'contenteditable' => false,
					'data-type' => 'radio',
					'html'=>$sex,
				],
//				'rights' => [
//					'className' => 'rights',
//					'field' => 'rights',
//					'name' => 'Права',
//					'width' => '1fr',
//					'data-type' => 'select',
//					'select' => $rights,
//				],

			],

			'delBttn' => 'ajax',
			'toListBttn' => true,
//			'saveBttn' => 'ajax',//'redirect'





]);
return $t->html;
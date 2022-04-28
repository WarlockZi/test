<?php

use app\view\components\CustomCatalogItem\CustomCatalogItem;
use \app\view\components\CustomSelect\CustomSelect;
use \app\view\components\CustomRadio\CustomRadio;
use \app\view\components\CustomDate\CustomDate;
use \app\view\components\CustomMultiSelect\CustomMultiSelect;

if ($item) {

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
		'className' => 'custom-radio',
		'title' => '',
		'field' => 'sex',
		'nameFieldName' => 'test_name',
		'tree' => ['m' => 'М', 'f' => 'Ж'],
		'selected' => 'm',
	]);
	$sex = $sex->html;

	$birthDate = new CustomDate([
		'className' => 'bdate',
		'title' => '',
		'field' => 'birthDate',
		'min' => '1965-01-01',
		'max' => '2005-01-01',
		'value' => $user['birthDate'],
	]);
	$birthDate = $birthDate->html;

	$hired = new CustomDate([
		'className' => 'hired',
		'field' => 'hired',
		'min' => '1965-01-01',
		'max' => '2005-01-01',
		'value' => $user['hired'],
	]);
	$hired = $hired->html;

	$fired = new CustomDate([
		'className' => 'fired',
		'field' => 'fired',
		'min' => '1965-01-01',
		'max' => '2005-01-01',
		'value' => $user['fired'],
	]);
	$fired = $fired->html;
//
//$rights = new CustomMultiSelect([
//	'selectClassName' => 'custom-select',
//	'title' => '',
//	'field' => 'rights',
//	'tab' => '&nbsp;&nbsp;&nbsp;',
//	'initialOption' => true,
//	'initialOptionValue' => '---',
//	'nameFieldName' => 'name',
//	'fieldName' => 'name',
//	'tree' => $rights,
//	'selected' => $user['rights'],
//]);
//$rights = $rights->html;

	$rights = include ROOT . '/app/view/User/getRightsTab.php';


	$t = new CustomCatalogItem([

		'item' => $item,
		'modelName' => $this->modelName,
		'tableClassName' => $this->tableName,

		'tabs' => [
			'Права' => $rights
		],

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
				'html' => $birthDate,
			],

			'hired' => [
				'className' => 'fired',
				'field' => 'hired',
				'name' => 'Принят в штат',
				'contenteditable' => true,
				'data-type' => 'date',
				'html' => $hired,
			],

			'fired' => [
				'className' => 'fired',
				'field' => 'fired',
				'name' => 'Уволен',
				'contenteditable' => true,
				'data-type' => 'date',
				'html' => $fired,
			],


			'sex' => [
				'className' => 'sex',
				'field' => 'sex',
				'name' => 'Пол',
				'contenteditable' => false,
				'data-type' => 'radio',
				'html' => $sex,
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

		'delBttn' => true,
		'toListBttn' => true,
		'saveBttn' => true


	]);
	return $t->html;

} else {

	ob_start();

	?>

	<div class="no-element">
		Элемент не найден
		<a class="to-list" href="/adminsc/<?= $this->modelName; ?>/list">К списку</a>
	</div>

	<?
	return ob_get_clean();
}

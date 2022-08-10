<?php

use app\model\User;
use app\view\components\CustomCatalogItem\CustomCatalogItem;


function getEmployeeHtml($item, $self)
{
	$options = employeeOptions($item, $self);
	$t = new CustomCatalogItem($options);
	return $t->html;
}

function getTabs($item)
{
	if (User::can($item, ['role_admin'])) {
		return ['title' => 'Права',
			'html' => getRights($item),
			'field' => 'rights'
		];
	}
	return ['title' => 'Права',
		'html' => 'Нужны права администратора'];
}

function employeeOptions($item, $self)
{

	$options = [
		'item' => $item,
		'modelName' => $self->modelName,
		'tableClassName' => $self->tableName,
		'pageTitle' => 'Редактировать пользователя: ' . $item['surName'],

		'tabs' => [getTabs($item)],

		'fields' => [
			'id' => [
				'className' => 'id',
				'field' => 'id',
				'name' => 'ID',
				'contenteditable' => '',
				'data-type' => 'number',
			],

			'email' => [
				'className' => 'email',
				'field' => 'email',
				'name' => 'email',
				'contenteditable' => false,
				'data-type' => 'string',
			],

			'surName' => [
				'className' => 'surName',
				'field' => 'surName',
				'name' => 'Фамилия',
				'contenteditable' => 'contenteditable',
				'data-type' => 'string',
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
				'html' => getBirhtdate($item),
			],
			'sex' => [
				'className' => 'sex',
				'field' => 'sex',
				'name' => 'Пол',
				'contenteditable' => false,
				'data-type' => 'radio',
				'html' => getSex($item),
			],

		],
		'delBttn' => true,
		'toListBttn' => true,
		'saveBttn' => true
	];

	if (User::can($item, ['role_admin'])) {
		$options['fields']= $options['fields']
			+ getConfirmRow($item)
			+ getHiredRow($item)
			+ getFiredRow($item);
	}

	return $options;
}



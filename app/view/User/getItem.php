<?php

use app\view\components\CustomCatalogItem\CustomCatalogItem;
use \app\view\components\CustomSelect\CustomSelect;
use \app\view\components\CustomRadio\CustomRadio;
use \app\view\components\CustomDate\CustomDate;
use \app\view\components\CustomMultiSelect\CustomMultiSelect;
use \app\model\User;

if ($item) {
  if (User::can($this->user, 'role_employee')) {
    return getEmployeeHtml($item, $this);
  } else {
    return getUserHtml($item, $this);
  }
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

function getSex($item)
{
  $sex = new CustomRadio([
    'className' => 'custom-radio',
    'title' => '',
    'field' => 'sex',
    'nameFieldName' => 'test_name',
    'tree' => ['m' => 'М', 'f' => 'Ж'],
    'selected' => $item['sex'],
  ]);
  return $sex->html;
}

function getBirhtdate($user)
{
  $birthDate = new CustomDate([
    'className' => 'bdate',
    'title' => '',
    'field' => 'birthDate',
    'min' => '1965-01-01',
    'max' => '2005-01-01',
    'value' => $user['birthDate'],
  ]);
  return $birthDate->html;
}

function getHired($user)
{
  $hired = new CustomDate([
    'className' => 'hired',
    'field' => 'hired',
    'min' => '1965-01-01',
    'max' => '2005-01-01',
    'value' => $user['hired'],
  ]);
  return $hired->html;
}

function getFired($user)
{
  $fired = new CustomDate([
    'className' => 'fired',
    'field' => 'fired',
    'min' => '1965-01-01',
    'max' => '2005-01-01',
    'value' => $user['fired'],
  ]);
  return $fired->html;
}

function getConfirm()
{
  $confirm = new CustomSelect([
    'selectClassName' => 'custom-select',
    'title' => '',
    'field' => 'confirm',
    'tab' => '&nbsp;&nbsp;&nbsp;',
//		'initialOption' => true,
//		'initialOptionValue' => '---',
    'nameFieldName' => 'test_name',
    'tree' => [1 => 'да', 0 => 'нет'],
    'selected' => [$item['confirm'] ?? 0],
  ]);
  return $confirm->html;
}

function getRights()
{
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
  return include ROOT . '/app/view/User/getRightsTab.php';
}

function getUserHtml($item, $self)
{
  $t = new CustomCatalogItem([
    'item' => $item,
    'modelName' => $self->modelName,
    'tableClassName' => $self->tableName,
    'pageTitle' => 'Редактировать пользователя: ' . $item['surName'] .' '. $item['name'],

    'fields' => [
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
}

function getEmployeeHtml($item, $self)
{
  $t = new CustomCatalogItem([

    'item' => $item,
    'modelName' => $self->modelName,
    'tableClassName' => $self->tableName,
    'pageTitle' => 'Редактировать пользователя: ' . $item['surName'],

    'tabs' => [
      'Права' => getRights()
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
        'html' => getConfirm(),
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
        'html' => getBirhtdate(),
      ],

      'hired' => [
        'className' => 'fired',
        'field' => 'hired',
        'name' => 'Принят в штат',
        'contenteditable' => true,
        'data-type' => 'date',
        'html' => getHired(),
      ],

      'fired' => [
        'className' => 'fired',
        'field' => 'fired',
        'name' => 'Уволен',
        'contenteditable' => true,
        'data-type' => 'date',
        'html' => getFired(),
      ],

      'sex' => [
        'className' => 'sex',
        'field' => 'sex',
        'name' => 'Пол',
        'contenteditable' => false,
        'data-type' => 'radio',
        'html' => getSex(),
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
}

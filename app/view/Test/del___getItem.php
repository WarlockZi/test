<?php

use app\view\components\CustomCatalogItem\CustomCatalogItem;


function getOptions($item, $self)
{
	$options = [
		'item' => $item,
		'modelName' => $self->model,
		'tableClassName' => $self->table,
		'pageTitle' => 'Редактировать тест: ' . $item['name'],

//    'tabs' => [
//      ['title' => 'Права',
//        'html' => getRights($item),
//        'field' => 'rights'
//      ]
//    ],

		'fields' => [
			'id' => [
				'className' => 'id',
				'field' => 'id',
				'name' => 'ID',
				'contenteditable' => false,
				'data-type' => 'number',
			],


			'name' => [
				'className' => 'name',
				'field' => 'name',
				'name' => 'Название теста',
				'contenteditable' => 'contenteditable',
				'data-type' => 'string',
			],

			'enable' => [
				'className' => 'enable',
				'field' => 'enable',
				'name' => 'Показывать пользователю',
				'contenteditable' => 'select',
				'html' => getEbabled($item),
				'data-type' => 'select',
			],
			'parent' => [
				'className' => 'enable',
				'field' => 'opentest_id',
				'name' => 'Лежит в папке',
				'contenteditable' => 'select',
				'html' => getParent($item),
				'data-type' => 'select',
			],
		],
		'delBttn' => true,
		'saveBttn' => true,
	];

//  if (User::can($item, ['role_admin'])) {
//    $options['fields'] = $options['fields'] + getConfirmRow($item);
//    $options['fields'] = $options['fields'] + getHiredRow($item);
//    $options['fields'] = $options['fields'] + getFiredRow($item);
//  }

	return $options;
}


function getRights($user)
{
	$rights = \app\model\Right::findAll();
	return include ROOT . '/app/view/User/getRightsTab.php';
}

function noElement($self)
{
	ob_start();
	?>
	<div class="no-element">
		Элемент не найден
		<a class="to-list" href="/adminsc/<?= $self->model; ?>">Вернуться</a>
	</div>
	<?
	return ob_get_clean();
}

if ($item) {
	return getHtml($item, $this);
} else {
	return noElement($this);
}


function getHtml($item, $self)
{
	$options = getOptions($item, $self);
	$t = new CustomCatalogItem($options);
	return $t->html;
}




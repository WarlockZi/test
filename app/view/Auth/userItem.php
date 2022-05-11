<?php

use app\view\components\CustomCatalogItem\CustomCatalogItem;
use app\view\components\CustomMultiSelect\CustomMultiSelect;

private function getMultiselectPosts($array, $selected = [])
{
  return new CustomMultiSelect([
    'className' => 'type1',
    'field' => 'post_id',
    'tab' => '.',
    'optionName' => 'name',
    'initialOption' => true,
    'initialOptionLabel' => '--',
    'initialOptionValue' => 0,
    'tree' => $array,
    'selected' => $selected,
  ]);
};

private function getItem($item)
{
  $item = new CustomCatalogItem(
    [
      'item' => $item,
      'modelName' => $this->modelName,
      'tableClassName' => $this->tableName,
      'fields' => [
        'id' => [
          'className' => 'id',
//						'field' => 'id',
          'name' => 'ID',
          'contenteditable' => '',
          'width' => '50px',
          'data-type' => 'number',
        ],
        'name' => [
          'className' => 'name',
//						'field' => 'name',
          'name' => 'Имя',
          'width' => '1fr',
          'contenteditable' => 'contenteditable',
          'data-type' => 'string',
        ],
        'surName' => [
          'className' => 'surname',
//						'field' => 'surName',
          'name' => 'Фамилия',
          'width' => '1fr',
          'contenteditable' => 'contenteditable',
          'data-type' => 'string',
        ],
        'email' => [
          'className' => 'email',
//						'field' => 'email',
          'name' => 'email',
          'width' => '1fr',
          'contenteditable' => false,
          'data-type' => 'string',
        ],

//				'post_id' => [
//					'className' => 'post',
////						'field' => 'post_id',
//					'name' => 'Должности',
//					'width' => '1fr',
//					'data-type' => 'multiselect',
//					'select' => $posts,
//				],
      ],

      'delBttn' => true,
      'toListBttn' => true,
      'saveBttn' => true
    ]
  );
  return $item->html;
}


<?php


namespace app\view;


use app\view\components\CustomCatalogItem\CustomCatalogItem;

class viewRepository
{
	public function list(){

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
				],

				'delBttn' => 'ajax',
				'saveBttn' => 'ajax',//'redirect'
				'toListBttn' => true,
			]
		);
		return $item->html;
	}

}
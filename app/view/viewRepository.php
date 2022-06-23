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
						'html' => $chiefs,
					],
					'subourdinate' => [
						'className' => 'fullname',
						'field' => 'subordinate',
						'name' => 'Управляет',
						'width' => '1fr',
						'data-type' => 'multiselect',
						'html' => $subordinates,
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
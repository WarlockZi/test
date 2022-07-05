<?php


namespace app\view\Videoinstruction;


use app\model\Videoinstruction;
use app\view\components\CustomList\CustomList;

class VideoinstructionView
{
	public function __construct()
	{
		$this->items = Videoinstruction::findAll();
		$this->modelName = 'videoinstruction';
		$this->tableName = 'videoinstructions';
	}

	public static function list()
	{
		$view = new static();
		$list = new CustomList(
			[
				'models' => $view->items,
				'modelName' => $view->modelName,
				'tableClassName' => $view->tableName,
				'columns' => [
					'id' => [
						'className' => 'id',
						'field' => 'id',
						'name' => 'ID',
						'width' => '50px',
						'data-type' => 'number',
						'sort' => true,
						'search' => false,
					],

					'sort' => [
						'className' => 'sort',
						'field' => 'sort',
						'name' => '№',
						'width' => '70px',
						'contenteditable' => 'contenteditable',
						'data-type' => 'string',
						'sort' => true,
						'search' => true,
					],
					'name' => [
						'className' => 'name',
						'field' => 'name',
						'name' => 'Название',
						'width' => '1fr',
						'contenteditable' => 'contenteditable',
						'data-type' => 'string',
						'sort' => true,
						'search' => true,
					],

					'link' => [
						'className' => 'link',
						'field' => 'link',
						'name' => 'Ссылка',
						'width' => '150px',
						'contenteditable' => 'contenteditable',
						'data-type' => 'string',
						'sort' => true,
						'search' => true,
					],

					'tag' => [
						'className' => 'tag',
						'field' => 'tag',
						'name' => 'Тэг',
						'width' => '1fr',
						'contenteditable' => 'contenteditable',
						'data-type' => 'string',
						'sort' => true,
						'search' => true,
					],


					'user_id' => [
						'className' => 'user_id',
						'field' => 'user_id',
						'name' => 'Доступы',
						'width' => '1fr',
						'contenteditable' => 'contenteditable',
						'data-type' => 'string',
						'sort' => true,
						'search' => true,
					],
				],
				'editCol' => false,
				'delCol' => 'ajax',
				'addButton' => 'ajax',//'redirect'
			]
		);
		return $list->html;
	}


}
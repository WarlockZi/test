<?php

namespace app\view\Right;

use app\model\Right;
use app\view\components\Builders\ListBuilder\ListColumnBuilder;
use app\view\components\Builders\ListBuilder\CustomList;
use app\view\MyView;
use Illuminate\Database\Eloquent\Model;

class RightView
{
	public $model = Right::class;
	public $html;

	public static function listAll(): string
	{
		$view = new self;
		return CustomList::build($view->model)
			->column(
				ListColumnBuilder::build('id')
					->name('ID')
					->get())
			->column(
				ListColumnBuilder::build('name')
					->name('Право')
					->search()
					->contenteditable()
					->sort()
					->width('1fr')
					->get())
			->column(
				ListColumnBuilder::build('description')
					->name('Описание')
					->contenteditable(true)
					->search(true)
					->width('1fr')
					->get()
			)
			->addButton('ajax')
			->del()
			->all()
			->get();
	}

  public static function getCheckList(array $configRights, array $rights, Model $user)
  {
    return include ROOT . '/app/view/User/getRightsTab.php';
	}

}
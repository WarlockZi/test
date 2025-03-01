<?php

namespace app\view\Right;

use app\model\Right;
use app\view\components\Builders\TableBuilder\ColumnBuilder;
use app\view\components\Builders\TableBuilder\Table;
use Illuminate\Database\Eloquent\Model;

class RightView
{

	public $html;

	public static function listAll(): string
	{
		return Table::build(Right::all())
			->column(
				ColumnBuilder::build('id')
					->name('ID')
					->get())
			->column(
				ColumnBuilder::build('name')
					->name('Право')
					->search()
					->contenteditable()
					->sort()
					->width('1fr')
					->get())
			->column(
				ColumnBuilder::build('description')
					->name('Описание')
					->contenteditable(true)
					->search(true)
					->width('1fr')
					->get()
			)
			->addButton()
            ->model('right')
			->del()
			->get();
	}

  public static function getCheckList(array $configRights, array $rights, Model $user)
  {
    return include ROOT . '/app/view/User/getRightsTab.php';
	}

}
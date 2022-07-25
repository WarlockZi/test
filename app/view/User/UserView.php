<?php


namespace app\view\User;


use app\model\User;
use app\view\components\ColumnBuilders\ListColumnBuilder;
use app\view\components\MyList\MyList;
use app\view\MyView;


abstract class UserView extends MyView
{

	public $model;
	public $html;


	public static function listAll(): string
	{
		return MyList::build(User::class)
			->column(
				ListColumnBuilder::build('id')
					->name('ID')
					->get())
			->column(
				ListColumnBuilder::build('name')
					->name('Имя')
					->search(true)
					->width('1fr')
					->get())
			->column(
				ListColumnBuilder::build('surName')
					->name('Фамилия')
					->search(true)
					->width('1fr')
					->get())
			->column(
				ListColumnBuilder::build('confirm')
					->name('co')

					->get())
			->edit()
			->all()
			->get();
	}

}
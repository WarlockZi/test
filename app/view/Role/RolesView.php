<?php

namespace app\view\Role;

use app\view\components\Builders\TableBuilder\ColumnBuilder;
use app\view\components\Builders\TableBuilder\Table;
use Illuminate\Database\Eloquent\Model;

class RolesView
{
    public function __construct()
    {
        return $this;
    }

    public $html;

	public static function all($roles): string
	{
		return Table::build($roles)
            ->pageTitle('Роли')
			->column(
				ColumnBuilder::build('id')
					->name('ID')
					->get())
			->column(
				ColumnBuilder::build('name')
					->name('Роль')
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
            ->model('role')
			->del()
			->get();
	}
}
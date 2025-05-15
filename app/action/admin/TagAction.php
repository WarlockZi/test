<?php

namespace app\action\admin;


use app\model\Tag;
use app\view\components\Builders\TableBuilder\ColumnBuilder;
use app\view\components\Builders\TableBuilder\Table;

class TagAction implements IShowTable
{
    public function __construct() { }

    public function table(): array
    {
        return Table::build(Tag::all())
            ->pageTitle('Тэги')
            ->del()
            ->addButton()
            ->column(
                ColumnBuilder::build('id')
                    ->get()
            )
            ->column(
                ColumnBuilder::build('name')
                    ->search()
                    ->contenteditable()
                    ->get()
            )
            ->get();
    }

}
<?php

namespace app\action\admin;


use app\model\Country;
use app\model\Manufacturer;
use app\view\components\Builders\TableBuilder\ColumnBuilder;
use app\view\components\Builders\TableBuilder\Table;

class CountryAction implements IShowTable
{
    public function __construct() { }

    public function table(): array
    {
        return Table::build(Country::all())
            ->pageTitle('Страны')
            ->model('country')
            ->addButton()
            ->column(
                ColumnBuilder::build('id')
                    ->width('50px')
                    ->get()
            )
            ->column(
                ColumnBuilder::build('name')
                    ->search()
                    ->contenteditable()
                    ->get()
            )
            ->del()
            ->get();
    }
}
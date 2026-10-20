<?php

namespace app\action\admin;


use app\model\Manufacturer;
use app\view\components\Builders\TableBuilder\ColumnBuilder;
use app\view\components\Builders\TableBuilder\Table;

class ManufacturerAction implements IShowTable
{
    public function __construct() { }

    public function table(): array
    {
        return Table::build(Manufacturer::with('country')->get())
            ->pageTitle('Поставщики')
            ->addButton()
            ->column(
                ColumnBuilder::build('id')
                    ->width('50px')
                    ->get()
            )
            ->column(
                ColumnBuilder::build('name')
                    ->headerTitle('Наименование')
                    ->headerSearch()
                    ->contenteditable()
                    ->get()
            )
            ->column(
                ColumnBuilder::build('country_id')
                    ->function(Manufacturer::class, 'countrySelect')
                    ->headerTitle('Страна')
                    ->get()
            )
            ->del()
            ->get();
    }
}
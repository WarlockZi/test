<?php

namespace app\view\Report\Admin;

use app\Services\ProductService;
use app\view\components\Builders\TableBuilder\ColumnBuilder;
use app\view\components\Builders\TableBuilder\Table;
use Illuminate\Database\Eloquent\Collection;

class ReportView
{
    public function filter(Collection|null $products, string $title): string
    {
        return Table::build($products)
            ->pageTitle($title)
            ->model('product')
            ->column(
                ColumnBuilder::build('id')
                    ->name('ID')
                    ->class('cell left')
                    ->width('15px')
                    ->get()
            )
            ->column(
                ColumnBuilder::build('art')
                    ->name('Арт')
                    ->class('cell left')
                    ->search()
                    ->width('70px')
                    ->get()
            )
            ->column(
                ColumnBuilder::build('name')
                    ->name('Наименование')
                    ->class('cell left')
                    ->search()
                    ->width('1fr')
                    ->get()
            )
            ->column(
                ColumnBuilder::build('matrix')
                    ->name('В матрице')
                    ->class('cell font-size-1-5em')
                    ->callback(function ($prod) {
                        return $prod->name ? (str_ends_with($prod->name, '*') ? '*' : '') : '';
                    })
                    ->width('30px')
                    ->get()
            )
            ->column(
                ColumnBuilder::build('img')
                    ->name('Картинка')
                    ->function(ProductService::class, 'productImg')
                    ->width('50px')
                    ->class('img')
                    ->get()
            )
            ->column(
                ColumnBuilder::build('instore')
                    ->class('cell')
                    ->name('Количество')
                    ->width('50px')
                    ->get()
            )
            ->column(
                ColumnBuilder::build('base_is_shippable')
                    ->name('баз=отгруж')
                    ->class('cell')
                    ->function(ProductService::class, 'baseIsShippable')
                    ->width('30px')
                    ->get()
            )

            ->edit()
            ->del()
            ->addButton()
            ->get() ?? 'Установите фильтры';
    }

}
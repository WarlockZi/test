<?php

namespace app\view\Report\Admin;

use app\model\Product;
use app\Services\ProductService;
use app\view\components\Builders\ListBuilder\ListColumnBuilder;
use app\view\components\Builders\ListBuilder\MyList;
use Illuminate\Database\Eloquent\Collection;

class ReportView
{
    public function haveDopUnit(Collection $products, string $title): string
    {
        return MyList::build(Product::class)
            ->pageTitle($title)
            ->column(
                ListColumnBuilder::build('id')
                    ->name('ID')
                    ->get()
            )
            ->column(
                ListColumnBuilder::build('art')
                    ->name('Арт')
                    ->search()
                    ->width('70px')
                    ->get()
            )
            ->column(
                ListColumnBuilder::build('name')
                    ->name('Наименование')
                    ->contenteditable()
                    ->search()
                    ->width('1fr')
                    ->get()
            )
            ->items($products)
            ->edit()
            ->del()
            ->addButton('ajax')
            ->get();
    }

    public function noDopUnit($products): string
    {
        return MyList::build(Product::class)
            ->pageTitle('Товары имеющие только базовую единицу')
            ->column(
                ListColumnBuilder::build('id')
                    ->name('ID')
                    ->get()
            )
            ->column(
                ListColumnBuilder::build('art')
                    ->name('Арт')
                    ->search()
                    ->width('70px')
                    ->get()
            )
            ->column(
                ListColumnBuilder::build('name')
                    ->name('Наименование')
                    ->contenteditable()
                    ->search()
                    ->width('1fr')
                    ->get()
            )
            ->items($products)
            ->edit()
            ->del()
            ->addButton('ajax')
            ->get();
    }

    public function noMinUnitList($products, string $title): string
    {
        return MyList::build(Product::class)
            ->pageTitle($title)
            ->column(
                ListColumnBuilder::build('id')
                    ->name('ID')
                    ->get()
            )
            ->column(
                ListColumnBuilder::build('art')
                    ->name('Арт')
                    ->search()
                    ->width('70px')
                    ->get()
            )
            ->column(
                ListColumnBuilder::build('name')
                    ->name('Наименование')
                    ->contenteditable()
                    ->search()
                    ->width('1fr')
                    ->get()
            )
            ->items($products)
            ->edit()
            ->del()
            ->addButton('ajax')
            ->get();
    }

    public function filter(Collection $products, string $title): string
    {
        return MyList::build(Product::class)
            ->pageTitle($title)
            ->column(
                ListColumnBuilder::build('id')
                    ->name('ID')
                    ->get()
            )
            ->column(
                ListColumnBuilder::build('art')
                    ->name('Арт')
                    ->search()
                    ->width('70px')
                    ->get()
            )
            ->column(
                ListColumnBuilder::build('name')
                    ->name('Наименование')
                    ->class('cell left')
                    ->search()
                    ->width('1fr')
                    ->get()
            )
            ->column(
                ListColumnBuilder::build('print_name')
                    ->name('В матрице')
                    ->class('cell font-size-1-5em')
                    ->callback(function ($prod) {
                        return str_ends_with($prod->name,'*')?'*':'';
                    })
                    ->width('50px')
                    ->get()
            )
            ->column(
                ListColumnBuilder::build('img')
                    ->name('Картинка')
                    ->function(ProductService::class, 'productImg')
                    ->width('100px')
                    ->get()
            )
            ->column(
                ListColumnBuilder::build('instore')
                    ->name('Количество')
//                    ->field('instore')
                    ->width('100px')
                    ->get()
            )
            ->column(
                ListColumnBuilder::build('base_is_shippable')
                    ->name('баз=отгруж')
                    ->class('cell')
                    ->function(ProductService::class, 'baseIsShippable')
                    ->width('50px')
                    ->get()
            )
            ->items($products)
            ->edit()
            ->del()
            ->addButton('ajax')
            ->get();
    }

    public function noImgNoInstoreList(Collection $products, string $title): string
    {
        return MyList::build(Product::class)
            ->pageTitle($title)
            ->column(
                ListColumnBuilder::build('id')
                    ->name('ID')
                    ->get()
            )
            ->column(
                ListColumnBuilder::build('art')
                    ->name('Арт')
                    ->search()
                    ->width('70px')
                    ->get()
            )
            ->column(
                ListColumnBuilder::build('name')
                    ->name('Наименование')
                    ->contenteditable()
                    ->search()
                    ->width('1fr')
                    ->get()
            )
            ->items($products)
            ->edit()
            ->del()
            ->addButton('ajax')
            ->get();
    }

}
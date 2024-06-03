<?php

namespace app\view\Report\Admin;

use app\model\Product;
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
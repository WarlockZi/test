<?php

namespace app\action\admin;


use app\blade\views\admin\report\productFilter\FilterView;
use app\repository\ProductFilterRepository;
use app\service\Auth\Auth;
use app\service\Filters\Products\InitialFiltersService;
use app\service\Product\ProductService;
use app\view\components\Builders\TableBuilder\ColumnBuilder;
use app\view\components\Builders\TableBuilder\Table;

class ReportFilterProductsAction
{
    public function __construct(

        protected FilterView              $filterView ,
        protected InitialFiltersService $initialFilters,
    ) { }
    public function getSavedFilters(): array
    {
        return ProductFilterRepository::product(Auth::getUser()->id);
    }
    public function getFilterPanel(array $toFilter = [], array $toSave = []): array
    {
        $toSave  = count($toSave) ? $toSave : $toFilter;
        $filters = [];
        $initialFilters = $this->initialFilters->get();
        foreach ( $initialFilters as $filterName => $filterOptions) {
            $filters[] = (new FilterView())
                ->filterName($filterName)
                ->toFilter($toFilter)
                ->toSave($toSave)
                ->options($filterOptions['options'])
                ->title($filterOptions['title'])
                ->emptyOption()
                ->get();
        }
        return $filters;
//        return $this->filterView->getProductFilterPanel($filters);
    }

    public function filter(array $userFilters): array
    {
        return Table::build(ProductFilterRepository::filterProducts($userFilters))
            ->pageTitle('Фильтр')
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
                    ->width('minmax(30px, 70px)')
                    ->get()
            )
            ->column(
                ColumnBuilder::build('name')
                    ->name('Наименование')
                    ->class('cell left')
                    ->search()
                    ->width('minmax(60px,1fr)')
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
                ColumnBuilder::build('is_base')
                    ->name('баз=отгруж')
                    ->class('cell')
                    ->function(ProductService::class, 'baseIsShippable')
                    ->width('30px')
                    ->get()
            )
            ->edit()
            ->del()
            ->get() ;
    }
}
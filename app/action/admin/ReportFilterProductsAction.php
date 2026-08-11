<?php

namespace app\action\admin;


use app\blade\Blade;
use app\blade\views\admin\report\productFilter\FilterView;
use app\model\FilterUser;
use app\repository\ProductFilterRepository;
use app\service\AuthService\Auth;
use app\service\Filters\Products\InitialFiltersService;
use app\service\Image\del\ProductImageService;
use app\view\components\Builders\TableBuilder\ColumnBuilder;
use app\view\components\Builders\TableBuilder\Table;

class ReportFilterProductsAction
{
    public function __construct(
        public array $initialFilters = [],
    )
    {
        $this->initialFilters = InitialFiltersService::get();
    }

    public function initialFilters(): array
    {
        return $this->initialFilters;
    }

    public function saveFilters(array $prparedToSave): void
    {
        $json = json_encode($prparedToSave);
        FilterUser::updateOrCreate(
            ["user_id" => Auth::getUser()['id'],
                "model" => 'product',
            ],
            ["user_id" => Auth::getUser()['id'],
                "model" => 'product',
                'name' => $json,
            ]);
    }

    public function getSavedFilters(): array
    {
        return ProductFilterRepository::product(Auth::getUser()->id);
    }

    public function panel(array $toFilter = [], array $toSave = []): array
    {
        $toSave         = count($toSave) ? $toSave : $toFilter;
        $filters        = [];
        $initialFilters = $this->initialFilters;
        foreach ($initialFilters as $filterName => $filterOptions) {
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
    }

    public function panelHtml(array $toSelect = [], array $toSave = []): string
    {
        $filterPanel = $this->panel($toSelect, $toSave);
        return APP
            ->get(Blade::class)
            ->run("admin.report.productFilter.panel", compact('filterPanel'));
    }

    public function toSelectToSave(array $req): array
    {
        $toSave   = [];
        $toSelect = [];
        foreach ($req['changedFilters'] as $filterName => $filter) {
            if ($filter['checked'] && $filter['value']) {
                $toSave[$filterName] = $filter['value'];
            }
            if ($filter['value']) {
                $toSelect[$filterName] = $filter['value'];
            }
        }
        return [$toSave, $toSelect];
    }

    public function filterString(array $req): array
    {
        return array_filter($req, function ($filter) {
            return $filter <> '0' && $filter <> 'on';
        });
    }

    public function filterStringHtml(array $req = []): string
    {
        $filterString   = $this->filterString($req);
        $initialFilters = $this->initialFilters;
        return APP
            ->get(Blade::class)
            ->run("admin.report.productFilter.filterString",
                compact('filterString', 'initialFilters'));

    }

    public function tableHtml($userFilters)
    {
        $data  = $this->table($userFilters);
        $blade = APP->get(Blade::class);
        return $blade->run("admin.components.table.tableStandAlone", compact('data'));
    }


    public function table(array $userFilters): array
    {
        $repo     = new ProductFilterRepository();
        $products = $repo->filterProducts($userFilters);
        return Table::build($products)
            ->pageTitle('Фильтр')
            ->data(['model' => 'product'])
            ->column(
                ColumnBuilder::build('#')
                    ->callback(function ($item) {
                        return $item->id;
                    })
                    ->class('cell left')
                    ->width('clamp(40px, 10vw, 55px)')
                    ->get()
            )
            ->column(
                ColumnBuilder::build('Арт')
                    ->callback(function ($item) {
                        return $item->art;
                    })
                    ->class('cell left')
                    ->headerSearch()
                    ->width('clamp(50px, 14vw, 135px)')
                    ->get()
            )
            ->column(
                ColumnBuilder::build('Наименование')
                    ->callback(function ($item) {
                        return "<a href='/adminsc/product/edit/{$item->id}'>$item->name</a>";
                    })
                    ->class('cell left')
                    ->headerSearch()
                    ->width('minmax(60px,1fr)')
                    ->get()
            )
            ->column(
                ColumnBuilder::build('В матр')
                    ->class('cell')
                    ->callback(function ($prod) {
                        return $prod->name ? (str_ends_with($prod->name, '*') ? '*' : '') : '';
                    })
                    ->width('60px')
                    ->get()
            )
            ->column(
                ColumnBuilder::build('Картинка')
                    ->callback(function ($product) {
                        $imgPath             = image($product->ownProperties->main_image);
                        return "<img src='{$imgPath}' loading='lazy'>";
                    }
                    )
                    ->width('120px')
                    ->class('img')
                    ->get()
            )
            ->column(
                ColumnBuilder::build('В налич')
                    ->callback(function ($prod) {
                        return $prod->instore;
                    })
                    ->class('cell')
                    ->width('60px')
                    ->get()
            )
            ->get();
    }
}
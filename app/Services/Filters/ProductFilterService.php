<?php

namespace app\Services\Filters;

use app\core\Auth;
use app\core\FS;
use app\model\Category;
use app\model\FilterUser;
use app\Repository\CategoryRepository;
use app\Repository\ProductFilterRepository;
use app\view\components\Traits\CleanString;
use app\view\Filter\FilterView;

class ProductFilterService
{
    use CleanString;

    private FS $fs;
    private array $userFilters;
    private string $userFilterString;
    private array $initialFilters;
    private string $filterPanel;
    private FilterView $filterView;
    private ProductFilterRepository $filterRepository;

    public function __construct()
    {
        $this->fs               = new FS(__DIR__);
        $this->filterView       = new FilterView();
        $this->filterRepository = new ProductFilterRepository();
        $this->initialFilters   = $this->getInitialFilters();
    }

    public function getSavedFilters(): array
    {
        return ProductFilterRepository::product(Auth::getUser()->id);
    }

    public function getFilterString(array $req): string
    {

        $notNull = array_filter($req, function ($filter) {
            return $filter <> '0' && $filter <> 'on';
        });
        $str     = '';
        foreach ($this->initialFilters as $name => $data) {
            $filterRuName = $data['title'];
            if (array_key_exists($name, $notNull)) {
                $selected     = $data['options'][$notNull[$name]];
                $selectedSpan = "<span class='selected-value'>{$selected}</span>";
                $filterSpan   = "<span class='selected-filter'>{$filterRuName}{$selectedSpan}</span>";
            } else {
                $selected     = "*";
                $selectedSpan = "<span>{$selected}</span>";
                $filterSpan   = "<span>{$filterRuName}{$selectedSpan}</span>";
            }
            $str .= $filterSpan;
        }
        return "<div class='used-filters'>{$str}</div>";
    }


    public function filtersFromReq(array $req): array
    {
        if (!count($req)) return [];
        $selectFilters = [];
        $toSaveFilters = [];
        foreach ($req as $string => $value) {
            if (str_ends_with($string, '-filter')) {
                $key                 = str_replace('-filter', '', $string);
                $value               = $req[$key];
                $toSaveFilters[$key] = $value;
            } else {
                $selectFilters[$string] = $value;
            }
        }
        $arr = [0 => $selectFilters, 1 => $toSaveFilters];
        return $arr;
    }


    public function getFilterPanel(array $toFilter = [], array $toSave = []): string
    {
        $toSave  = count($toSave) ? $toSave : $toFilter;
        $filters = '';
        foreach ($this->initialFilters as $filterName => $filterOptions) {
            $filters .= $this->filterView
                ->filterName($filterName)
                ->toFilter($toFilter)
                ->toSave($toSave)
                ->options($filterOptions['options'])
                ->title($filterOptions['title'])
                ->emptyOption()
                ->get();
        }
        return $this->clean($this->filterView->getProductFilterPanel($filters));
    }

    private function preg_array_key_exists($pattern, $array): int
    {
        $keys = array_keys($array);
        return (int)preg_grep($pattern, $keys);
    }

    public function saveFilters(array $toSave): void
    {
        $json = json_encode($toSave);
        FilterUser::updateOrCreate(
            ["user_id" => Auth::getUser()['id'],
                "model" => 'product',
            ],
            ["user_id" => Auth::getUser()['id'],
                "model" => 'product',
                'name' => $json,
            ]);
    }

    protected function categoriesSelector(): array
    {
//        return Cache::get('productFilterCategoriesSelector', function () {
        $CategoryFlatNestedArray = [0 => ''];
        foreach (CategoryRepository::rootCategories()->reverse() as $rootCat) {
            $c      = Category::find($rootCat->id)
                ->flatSelfAndChildren
                ->map(function ($q) {
                    return $q;
                })
                ->keyBy('id')
                ->toArray();
            $result = array_combine(
                array_keys($c),
                array_map(function ($v) use (&$CategoryFlatNestedArray) {
                    $CategoryFlatNestedArray[$v['id']] = $v['name'];
                }, $c)
            );
        }
        return $CategoryFlatNestedArray;
//        }, 10000);
    }

    public function getInitialFilters(): array
    {
//        return Cache::get('initialFilters', function () {
        $CategoryFlatNestedArray = $this->categoriesSelector();
        return include 'productFilters.php';
//        }, 10);
    }

//    private function userFiltersDB(array $req): array
//    {
//        return array_map(function ($key) {
//            return $key['id'];
//        }, $req);
//    }
}
<?php

namespace app\Services\Filters;

use app\core\Auth;
use app\core\Cache;
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

    public function __construct(array $req)
    {
        $this->fs               = new FS(__DIR__);
        $this->filterView       = new FilterView();
        $this->filterRepository = new ProductFilterRepository();
        $this->saveUserFilters($req);
        $this->initialFilters   = $this->setInitialFilers();
        $this->userFilterString = $this->setUserFilterString($req);
        $this->userFilters      = $this->prepareUserFilters();
        $this->filterPanel      = $this->setFilterPanel();
    }

    public function setUserFilterString(array $req): string
    {
        if (empty($req)) {
            $req = $this->prepareUserFilters();
            $req = $this->userFiltersDB($req);
        }
        $notNull = array_filter($req, function ($filter) {
            return $filter <> '0' && $filter <> 'on';
        });
        $str     = '';
        foreach ($this->initialFilters as $filter => $value) {
            $filterRuName = $value['title'];
            if (array_key_exists($filter, $notNull)) {
                $selected     = $value['options'][$notNull[$filter]];
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

    private function userFiltersDB(array $req): array
    {
        return array_map(function ($key){
                return $key['id'];
        },$req);
    }

    private function userFiltersFromReq(array $req): array
    {
        if (!count($req)) return [];
        $userFilters = [];
        foreach ($req as $index => $item) {
            if (str_ends_with($index, '-filter')) {
                $key               = str_replace('-filter', '', $index);
                $value             = $req[$key];
                $userFilters[$key] = $value;
            }
        }
        return $userFilters;
    }

    protected function prepareUserFilters(): array
    {
        $userFilters = ProductFilterRepository::product(Auth::getUser()->id);
        if (!empty($userFilters)) {
            $obj       = json_decode($userFilters['name']);
            $formatted = [];
            foreach ($obj as $filter => $selected) {
                $formatted[$filter]['id'] = $selected;
            }
            return $formatted;
        }
        return [];
    }

    protected function setInitialFilers()
    {
        return Cache::get('initialFilters', function () {
            return $this->getInitialFilters();
        }, 10);
    }

    protected function setFilterPanel(): string
    {
        $filters = '';
        foreach ($this->initialFilters as $filter => $values) {
            $filters .= $this->filterView
                ->filterName($filter)
                ->userFilters($this->userFilters)
                ->options($values['options'])
                ->selectName($filter)
                ->title($values['title'])
                ->checkboxSave($filter)
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

    public function saveUserFilters(array $req): array|null
    {
        if (empty($req) || !$this->preg_array_key_exists('/.+-filter$/', $req)) return null;
        $reqFilters = $this->userFiltersFromReq($req);
        $json       = json_encode($reqFilters);
        FilterUser::updateOrCreate(
            ["user_id" => Auth::getUser()['id'],
                "model" => 'product',
            ],
            ["user_id" => Auth::getUser()['id'],
                "model" => 'product',
                'name' => $json,
            ]);
        return $reqFilters;

    }

    protected function categoriesSelector(): array
    {
        return Cache::get('productFilterCategoriesSelector', function () {
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
        }, 10000);
    }

    public function getInitialFilters(): array
    {
        $CategoryFlatNestedArray = $this->categoriesSelector();
        return include 'productFilters.php';
    }

    public function getUserFilters(): array
    {
        return $this->userFilters;
    }

    public function getUserFilterString(): string
    {
        return $this->userFilterString;
    }

    public function getFilterPanel(): string
    {
        return $this->filterPanel;
    }

}
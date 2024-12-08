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
    private string $filterPanel;
    private FilterView $filterView;
    private ProductFilterRepository $filterRepository;

    public function __construct()
    {
        $this->fs               = new FS(__DIR__);
        $this->filterView       = new FilterView();
        $this->filterRepository = new ProductFilterRepository();
    }

    public function setUserFilters(): void
    {
        $userFilters = ProductFilterRepository::product(Auth::getUser()->id);

        if (empty($userFilters)) {
            $this->userFilters = [];
        } else {
            $obj       = json_decode($userFilters['name']);
            $formatted = [];
            foreach ($obj as $filter => $selected) {
                $formatted[$filter]['id'] = $selected;
            }
            $this->userFilters = $formatted;
        }
    }

    public function saveUserFilters(array $req): array
    {
        $reqFilters = $this->getUserFilters($req);
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

    public function getUserFilters(array $req): array
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


    public function getInitialFilters(): array
    {
        $CategoryFlatNestedArray = [];
        foreach (CategoryRepository::frontCategories()->reverse() as $rootCat) {
            $c                       = Category::find($rootCat->id)
                ->flatSelfAndChildren
                ->map(function ($q) {
                    return $q;
                })
                ->keyBy('id')
                ->toArray();
            $result                  = array_combine(
                array_keys($c),
                array_map(function ($v) {
                    return $v['name'];
                }, $c)
            );
            $CategoryFlatNestedArray = [...$result, ...$CategoryFlatNestedArray];
        }

        return include 'productFilters.php';
    }

    public function get(): ProductFilterService
    {
        $initialFilters         = Cache::get('initialFilters', function () {
            return $this->getInitialFilters();
        },10);
        $this->userFilterString = $this->setUserFilterString($_POST, $initialFilters);
        $this->setUserFilters();

        $filters = '';
        foreach ($initialFilters as $filter => $values) {
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
        $this->filterPanel = $this->clean($this->filterView->getProductFilter($filters));
        return $this;
    }


    private function getSelectedCategoryName($value): string
    {
        preg_match('/selected>(&nbsp;)*(.*?)\<\/option/', $value['options'], $matches);
        return $matches[2];
    }

    public function setUserFilterString(array $req, array $initialFilters): string
    {
        $notNull = array_filter($req, function ($filter) {
            return $filter <> '0' && $filter <> 'on';
        });
        $str     = '';
        foreach ($initialFilters as $filter => $value) {
            $filterRuName = $value['title'];
            if (array_key_exists($filter, $notNull)) {
                $selected = $value['options'][$notNull[$filter]];
//                $selected = $filter === 'category'
//                    ? $this->getSelectedCategoryName($value)
//                    : $value['options'][$notNull[$filter]];
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

    public function getUserFilterString(): string
    {
        return $this->userFilterString;
    }

    public function getFilterPanel(): string
    {
        return $this->filterPanel;
    }

}
<?php

namespace app\Services\Filters;

use app\core\Auth;
use app\model\FilterUser;
use app\Repository\CategoryRepository;
use app\Repository\ProductFilterRepository;
use app\view\components\Builders\SelectBuilder\optionBuilders\TreeOptionsBuilder;
use app\view\Filter\FilterView;

class ProductFilterService
{
    private array $initialfilters;
    private array $userFilters;
    private string $userFilterString;
    private string $filterPanel;
    private FilterView $filterView;
    private ProductFilterRepository $filterRepository;

    public function __construct()
    {
        $this->filterView       = new FilterView();
        $this->filterRepository = new ProductFilterRepository();
    }

    public function setUserFilters(): array
    {
        $userFilters = ProductFilterRepository::product(Auth::getUser()['id']);

        $obj = $userFilters ? json_decode($userFilters['name']) : null;
        if (empty($obj)) {
            $obj = new \stdClass();
        }
        $args      = get_object_vars($obj);
        $formatted = [];
        foreach ($args as $filter => $selected) {
            $formatted[$filter]['id'] = $selected;
        }
        $this->userFilters = $formatted;
        return $formatted;
    }

    public function saveUserFilters(array $req): array
    {
        $reqFilters = $this->getUserFilters($req);
        $json       = json_encode($reqFilters);
        $find       = [
            "user_id" => Auth::getUser()['id'],
            "model" => 'product',
        ];
        $new        = [
            "user_id" => Auth::getUser()['id'],
            "model" => 'product',
            'name' => $json,
        ];

        FilterUser::updateOrCreate($find, $new)->toArray();
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
        $CategoryFlatNestedArray = TreeOptionsBuilder::build(
            CategoryRepository::treeAll(),
            'childrenRecursive',
            2)
            ->initialOption()
            ->getFlatNestedArray();
        return include 'productFilters.php';
    }

    public function get(): ProductFilterService
    {
        $initialFilters         = $this->getInitialFilters();
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
        $this->filterPanel = $this->filterView->getProductFilter($filters);
        return $this;
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

    public function getUserFilterString(): string
    {
        return $this->userFilterString;
    }

    public function getFilterPanel(): string
    {
        return $this->filterPanel;
    }
//    public function mergeInitialAndUserFilters(array $init, array $users)
//
//        foreach ($users as $index => $filter) {
//            if (key_exists(key($filter), $this->initialfilters)) {
//                $this->initialfilters[key($filter)]['selected'] = true;
//
//            }
//        }
//    }
}
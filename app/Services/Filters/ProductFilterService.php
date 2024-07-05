<?php

namespace app\Services\Filters;

use app\core\Auth;
use app\model\FilterUser;
use app\Repository\ProductFilterRepository;
use app\view\Filter\FilterView;

class ProductFilterService
{
    private array $initialfilters;
    private array $userFilters;
    private string $model = 'product';
    private FilterView $filterView;
    private ProductFilterRepository $filterRepository;

    public function __construct()
    {
        $this->filterView = new FilterView();
        $this->filterRepository = new ProductFilterRepository();
    }

    public function setUserFilters(): array
    {
        $userFilters = ProductFilterRepository::product(Auth::getUser()['id']);

        $obj = $userFilters ? json_decode($userFilters['name']) : null;
        if (empty($obj)) {
            $obj = new \stdClass();
        }
        $args = get_object_vars($obj);
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
        $json = json_encode($reqFilters);
        $find = [
            "user_id" => Auth::getUser()['id'],
            "model" => 'product',
        ];
        $new = [
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
                $key = str_replace('-filter', '', $index);
                $value = $req[$key];
                $userFilters[$key] = $value;
            }
        }
        return $userFilters;
    }

    public function factory(string $type): string
    {
        if ($type == 'admin') {
            $userFilter = $this->setUserFilters();
            $initialfilters = include 'productFilters.php';

            $filters = '';
            foreach ($initialfilters as $filter => $values) {
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
        }
        return $this->filterView->getProductFilter($filters);
    }

    public function getUserFilterString($req): string
    {
        $notNull = array_filter($req, function ($filter) {
            return $filter <> '0' && $filter <> 'on';
        });
        $initialfilters = include 'productFilters.php';
        $str = '';
        foreach ($initialfilters as $filter => $value) {
            $filterRuName = $value['title'];
            $selected = "*";
            $selectedSpan = "<span>{$selected}</span>";
            $filterSpan = "<span>{$filterRuName}{$selectedSpan}</span>";
            if (array_key_exists($filter, $notNull)) {
                $selected = $value['options'][$notNull[$filter]];
                $selectedSpan = "<span class='selected-value'>{$selected}</span>";
                $filterSpan = "<span class='selected-filter'>{$filterRuName}{$selectedSpan}</span>";
            }
            $str .= $filterSpan;
        }
        return "<div class='used-filters'>{$str}</div>";
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
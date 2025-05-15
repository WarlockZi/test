<?php

namespace app\service\Filters\Products;

use app\blade\views\admin\report\productFilter\FilterView;
use app\model\FilterUser;
use app\repository\ProductFilterRepository;
use app\service\AuthService\Auth;

class FilterService
{

    private array $initialFilters;
    public function __construct()
    {
        $this->initialFilters = InitialFiltersService::get();
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


    public function filtersFromReq(array $req = []): array
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

}
<?php

namespace app\service\Filters\Products;

use app\model\FilterUser;
use app\service\AuthService\Auth;

class FilterService
{

    public array $initialFilters;
    public array $notNull;
    public function __construct()
    {
        $this->initialFilters = InitialFiltersService::get();
    }


    public function getFilterString(array $req): self
    {
        $this->notNull = array_filter($req, function ($filter) {
            return $filter <> '0' && $filter <> 'on';
        });
        return $this;
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
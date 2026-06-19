<?php


namespace app\repository;


use app\model\Property;

class PropertyRepository
{
    public static function updateOrcreate(array $req)
    {
        $id   = $req['relation']['id'];
        $prop = [
            'name' => $req['relation']['field']['name'],
        ];
        return Property::updateOrCreate(['id' => $id], $prop);
    }

}
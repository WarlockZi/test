<?php


namespace app\Repository;


use app\model\Role;
use Illuminate\Database\Eloquent\Collection;

class RolesRepository
{

    public static function all(): Collection
    {
        return Role::all();
    }


}
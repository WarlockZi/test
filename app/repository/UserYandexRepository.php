<?php


namespace app\repository;


use app\model\User;
use app\model\UserYandex;

class UserYandexRepository
{
    public function __construct()
    {
    }
    public static function getByEmail(string $email, array $select = [], array $withRelations = []): ?UserYandex
    {
        $query = UserYandex::query()->where('default_email', $email);

        if (!empty($select)) {
            $query->select(...$select);
        }
        if (!empty($withRelations)) {
            foreach ($withRelations as $relation) {
                $query->with($relation);
            }
        }

        return $query->first();
    }


}
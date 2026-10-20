<?php

namespace app\factory;

use app\service\AuthService\AuthService;
use app\storage\DatabaseCartStorage;
use app\storage\SessionCartStorage;

class CartStorageFactory
{
    public static function create(): DatabaseCartStorage|SessionCartStorage
    {
        $user = AuthService::getUser();

        if ($user) {
            return new DatabaseCartStorage($user->id);
        }

        return new SessionCartStorage();
    }
}
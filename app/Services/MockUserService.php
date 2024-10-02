<?php

namespace app\Services;

use app\core\Auth;

class MockUserService
{
    public static function mockUser()
    {
        $user     = Auth::getUser();
        $mockUser = \app\model\User::query()->find(160);
        $Olya     = \app\model\User::query()
            ->where('email', 'vitex018@yandex.ru')
            ->first();
        Auth::setUser($Olya);
    }

}
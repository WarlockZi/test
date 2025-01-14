<?php

namespace app\Services;

use app\core\Auth;

class MockUserService
{
    public static function mockUser()
    {
        $Olya = \app\model\User::query()
            ->where('email', 'vitex018@yandex.ru')
            ->first();
        $Oleg = \app\model\User::query()
            ->where('email', 'molchinoleg@mail.ru')
            ->first();
        $yandexVvoronik = \app\model\UserYandex::query()
            ->where('default_email', 'vvoronik@yandex.ru')
            ->first();
        Auth::setUser($yandexVvoronik);
    }

}
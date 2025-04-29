<?php

namespace app\model\Mock;

use app\model\User;
use app\model\UserYandex;
use app\service\AuthService\Auth;

class MockUserService
{
    public static function mockUser()
    {
        $MarinaDemis    = User::where('email', 'p.shishkov@demis.ru')
            ->first();
        $Olya           = User::where('email', 'vitex018@yandex.ru')
            ->first();
        $Oleg           = User::where('email', 'molchinoleg@mail.ru')
            ->first();
        $yandexVvoronik = UserYandex::where('default_email', 'vvoronik@yandex.ru')
            ->first();

        Auth::setUser($MarinaDemis);
    }

}
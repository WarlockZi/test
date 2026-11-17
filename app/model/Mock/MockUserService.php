<?php

namespace app\model\Mock;

use app\model\User;
use app\model\UserYandex;
use app\service\AuthService\AuthService;

class MockUserService
{
    public static function mockUser()
    {
        $MarinaDemis    = User::where('email', 'p.shishkov@demis.ru')
            ->first();
        $o = env('EMAIL_OLYA');
        $Olya           = User::where('email', $o)->first();
        $yandexVvoronik = UserYandex::where('default_email', 'vvoronik@yandex.ru')
            ->first();

        return $Olya;
    }

}
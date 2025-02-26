<?php

namespace app\Repository;

use app\model\Callme;
use Throwable;

class CallmeRepository
{
    public static function firstOrCreate(array $req): bool
    {
        try {
            $callme = Callme::firstOrCreate([
                'php_session' => $req['php_session'],
                'phone' => $req['phone'],
            ], [
                'php_session' => $req['php_session'],
                'phone' => $req['phone'],
            ]);
            return true;
        } catch (Throwable $exception) {
            return false;
        }
    }
}
<?php

namespace app\service\PasswordGenerator;

use app\service\ShortLink\ShortlinkService;

class PasswordGeneratorService
{
    const SALT = "popiyonovacheesa";


    public static function generate(): string
    {
        $newPassword = PasswordGeneratorService::randomPassword();
        return PasswordGeneratorService::hashPassword($newPassword);
    }

    public static function randomPassword(): string
    {
        return ShortlinkService::create(8);
    }

    public static function hashPassword(string $password): string
    {
        return md5($password . self::SALT);
    }
}
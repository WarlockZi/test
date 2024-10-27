<?php

namespace app\core;

use app\model\User;
use app\model\UserYandex;

class Auth
{
    protected static IUser|null $user = null;
    protected static Auth $instance;

    protected function __construct()
    {
    }

    protected function __clone()
    {
    }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    public static function hasPphSession(array $req): bool
    {
        if ($req && isset($req['phpSession']) && $req['phpSession'] && $_SESSION['phpSession'] === $req['phpSession']) {
            unset($req['phpSession']);
            return true;
        }
        return false;
    }

    public static function getUser(): IUser|null
    {
        return self::$user ?? self::auth();
    }

    private static function auth(): IUser|null
    {
        if (isset($_SESSION['id']) && $_SESSION['id']) {
            self::$user = User::find($_SESSION['id']);
            return self::$user;
        }
        if (isset($_SESSION['yandex_id']) && $_SESSION['yandex_id']) {
            self::$user = UserYandex::find($_SESSION['yandex_id']);
            return self::$user;
        }
        return null;
    }

    public static function isSU(): bool
    {
        return $_ENV['SU_EMAIL'] === self::$user['email'];
    }

    public static function setAuth(IUser $user): void
    {
        if ($user instanceof User) {
            $_SESSION['id'] = $user->getId();
        } elseif ($user instanceof UserYandex) {
            $_SESSION['yandex_id'] = $user->getId();
        }
    }

    public static function setUser(IUser $mockuser): void
    {
        self::$user = $mockuser;
    }

    public static function userIsAdmin(): bool
    {
        return self::$user && self::$user->can(['role_admin']);
    }

    public static function isAuthed(): bool
    {
        return !!self::getUser();
    }

    public static function authorize(Route $route): IUser|null
    {
        if (AuthValidator::needsNoAuth($route)) {
            return null;//no user
        }

        $user = self::getUser();
        if (!$user) {
            header("Location:/auth/login");
            exit();
        }

        self::setAuth($user);
        if ($user instanceof User && !$user['confirm'] == "1") {
            $route->setError('Чтобы получить доступ, зайдите на рабочую почту, найдите письмо "Регистрация VITEX" и перейдите по ссылке в письме.');
            header("Location:/auth/noconfirm");
            exit();
        }
        define('SU', $user->mail() === $_ENV['SU_EMAIL']);

        return $user;
    }

}


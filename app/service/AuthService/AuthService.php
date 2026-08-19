<?php

namespace app\service\AuthService;

use app\model\User;
use app\model\UserYandex;

class AuthService
{
    protected static IUser|null $user = null;
    protected static AuthService $instance;
    protected static string $cartId;

    protected function __construct()
    {
    }

    public static function getUser(): ?IUser
    {
        return self::$user ?? self::auth();
    }
    public static function merge(): bool
    {
        //TODO merge cart
        //TODO merge likes
        //TODO merge compare
        return false;
    }
    private static function auth(): ?IUser
    {
        if (!empty($_SESSION['vitex_email_id'])) {
            self::$user = User::with('role')->find($_SESSION['vitex_email_id']);
            setcookie('vitex_gest_id', '', time() - 3600, '/');
            return self::$user;
        }
        if (!empty($_SESSION['vitex_yandex_id'])) {
            self::$user = UserYandex::with('role')->find($_SESSION['vitex_yandex_id']);
            setcookie('vitex_gest_id', '', time() - 3600, '/');
            return self::$user;
        }
        return null;
    }

    public static function isSU(): bool
    {
        return env('EMAIL_SU') === self::$user['email'];
    }

    public static function setUser(IUser $user): void
    {
        self::$user = $user;
    }

    public static function login(IUser $user): void
    {
        $ses = session_id();
        session_regenerate_id();
        $s = session_id();

        self::setUser($user);

        AuthService::merge();
        $user->saveToSession();
//        if ($user instanceof User) {
//            $_SESSION['vitex_email_id'] = $user->getId();
//        } elseif ($user instanceof UserYandex) {
//            $_SESSION['vitex_yandex_id'] = $user->getId();
//        }
    }

    public static function userIsAdmin(): bool
    {
        return self::$user && self::$user->isAdmin();
    }

    public static function userIsEmployee(): bool
    {
        return self::$user && self::$user->isEmployee();
    }

    public static function authorize(): void
    {
        $user = self::getUser();

        if (!$user) return;
    }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    protected function __clone()
    {
    }

}


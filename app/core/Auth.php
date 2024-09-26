<?php

namespace app\core;

use app\model\User;

class Auth
{
    protected static User|null $user = null;

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

    public static function getInstance(): self
    {
        $cls = static::class;
        if (!isset(self::$instance[$cls])) {
            self::$instance[$cls] = new static();
        }
        return self::$instance[$cls];
    }


    public static function hasPphSession(array $req): bool
    {
        if ($req && isset($req['phpSession']) && $req['phpSession'] && $_SESSION['phpSession'] === $req['phpSession']) {
            unset($req['phpSession']);
            return true;
        }
        return false;
    }

    public static function checkAuthorized(array $user, array $rights): void
    {
        if (!$user->can($rights)) {
            header("Location:/auth/unautherized");
        }
    }

    public static function getUser(): User|null
    {
        return self::$user ?? self::auth();
    }

    private static function auth(): User|null
    {
        if (isset($_SESSION['id']) && $_SESSION['id']) {
            self::$user = User::find($_SESSION['id']);
            return self::$user;
        }
        return null;
    }

    public static function isSU(): bool
    {
        return $_ENV['SU_EMAIL'] === self::$user['email'];
    }

    public static function isOlya(): bool
    {
        return 'vitex018@yandex.ru' === Auth::getUser()['email'];
    }

    public static function setAuth(User $user): void
    {
        $_SESSION['id'] = $user->id;
    }

    public static function setUser(User $mockuser): void
    {
        self::$user = $mockuser;
    }

    public static function getAuth(): User|null
    {
        if (!isset($_SESSION['id']) || $_SESSION['id']) return null;
        $user = User::find($_SESSION['id']);

        self::$user = $user ?? null;
        return $user;
    }


    public static function userIsAdmin(): bool
    {
        return self::$user && self::$user->can(['role_admin']);
    }

    public static function isAuthed(): bool
    {
        return !!self::getUser();
    }

    public static function authorize(Route $route): User|null
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
        if (!$user['confirm'] == "1") {
            $route->setError('Чтобы получить доступ, зайдите на рабочую почту, найдите письмо "Регистрация VITEX" и перейдите по ссылке в письме.');
            header("Location:/auth/noconfirm");
            exit();
        }

        if ($user['email'] === $_ENV['SU_EMAIL']) {
            define('SU', true);
        }
        return $user;
    }
}


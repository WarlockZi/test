<?php

namespace app\service\AuthService;

use app\model\User;
use app\model\UserYandex;

class Auth
{
    protected static IUser|null $user = null;
    protected static Auth $instance;
    protected static string $cartId;

    protected function __construct()
    {
    }

    public static function validatePphSession(array $req): bool
    {
        if (isConsole())  error_log('команда пришла из консоли');
        if (isConsole())  return true;

        return !empty($req['phpSession'])
            && session_id() === $req['phpSession'];
    }


    public static function getCartFieldValue(): array
    {
        $user  = Auth::getUser();
        $field = $user ? 'user_id' : 'vitex_guest_id';
        $value = $user ? $user->id : $_COOKIE['vitex_guest_id'] ?? NULL;
        return [$field, $value];
    }

    public static function getUser(): User|IUser|null
    {
        return self::$user ?? self::auth();
    }

    private static function auth(): IUser|null
    {
        if (!empty($_SESSION['id'])) {
            self::$user = User::with('role')->find($_SESSION['id']);
            return self::$user;
        }
        if (isset($_SESSION['vitex_yandex_id']) && $_SESSION['vitex_yandex_id']) {
            self::$user = UserYandex::with('role')->find($_SESSION['vitex_yandex_id']);
            return self::$user;
        }
        return null;
    }

    public static function isSU(): bool
    {
        return env('EMAIL_SU') === self::$user['email'];
    }
    public static function setUser(IUser $mockuser): void
    {
        self::$user = $mockuser;
    }
    public static function setAuth(IUser $user): void
    {
        if ($user instanceof User) {
            $_SESSION['id'] = $user->getId();
        } elseif ($user instanceof UserYandex) {
            $_SESSION['vitex_yandex_id'] = $user->getId();
        }
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

        if ($user instanceof User) {
            define('SU', $user->mail() === env('EMAIL_SU'));
        }
    }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    protected function __clone()
    {
    }


}


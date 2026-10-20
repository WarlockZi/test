<?php

namespace app\service\AuthService;

use app\action\AuthActions;
use app\action\CartAction;
use app\model\User;
use app\model\UserYandex;
use app\service\Account\AccountService;
use app\service\Cart\CartService;
use app\service\Compare\CompareService;
use app\service\Like\LikeService;

class AuthService
{
    protected static ?IUser $user = null;
    protected static AuthService $instance;

    protected function __construct()
    {
    }

    public static function getUser(): ?IUser
    {
        return self::$user ?? self::setUser();
    }

    public static function accountId(): ?int
    {
        return self::$user->account_id ?? self::setUser()?->account_id ?? null;
    }

    private static function merge(
        IUser          $user,
    ): void
    {
        $accountService = new AccountService();
        $account_id = $accountService->mergeAccount($user);

        $cartService = new CartService;
        $cartService->mergeCart($account_id);

        $likeService = new LikeService;
        $likeService->mergeLikes($account_id);

        $compareService =  new CompareService;
        $compareService->mergeCompares($account_id);
    }

    public static function login(IUser $user): void
    {
        $self = new self();
        $self::setUser($user);

        $self::merge($user);
        $user->saveToSession();
    }

    public static function setUser(?IUser $user = null): ?IUser
    {
        if (!empty($user)) {
            self::$user = $user;
            return self::$user;
        }
        if (!empty($_SESSION['vitex_email_id'])) {
            self::$user = User::with('role')->find($_SESSION['vitex_email_id']);
            return self::$user;
        }
        if (!empty($_SESSION['vitex_yandex_id'])) {
            self::$user = UserYandex::with('role')->find($_SESSION['vitex_yandex_id']);
            return self::$user;
        }
        return null;
    }


    public static function authorize(): void
    {
        $user = self::getUser();

        if (!$user) return;
    }

    public static function logout(): bool
    {
        try {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            if (!empty(session_id())) {
                session_regenerate_id(true); // true = удалить старую сессию
            }

            $_SESSION = [];

            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();

                setcookie(
                    session_name(),
                    '',
                    time() - 3600,
                    $params["path"],
                    $params["domain"],
                    $params["secure"],
                    $params["httponly"]
                );
            }

            $destroyed = session_destroy();

            if ($destroyed) {
                error_log(sprintf(
                    'User logged out successfully at %s from IP: %s',
                    date('Y-m-d H:i:s'),
                    $_SERVER['REMOTE_ADDR'] ?? 'unknown'
                ));
            } else {
                error_log(sprintf(
                    'Failed to destroy session at %s from IP: %s',
                    date('Y-m-d H:i:s'),
                    $_SERVER['REMOTE_ADDR'] ?? 'unknown'
                ));
            }

            return $destroyed;

        } catch (\Exception $e) {
            error_log(sprintf(
                'Error during logout: %s at %s',
                $e->getMessage(),
                date('Y-m-d H:i:s')
            ));

            return false;
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


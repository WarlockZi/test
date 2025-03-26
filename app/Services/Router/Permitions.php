<?php

namespace app\Services\Router;

use app\Services\AuthService\Auth;

class Permitions
{
    public static function isEmployeeOrAdmin(Route $route): bool
    {
        if ($route->isAdmin() && !(Auth::userIsAdmin()||Auth::userIsEmployee())) {
            return false;
        }
        return true;
    }

}
<?php

namespace app\service\Router;

use app\service\AuthService\Auth;

class Permitions
{
    public static function isEmployeeOrAdmin(Request $route): bool
    {
        if ($route->isAdmin() && !(Auth::userIsAdmin()||Auth::userIsEmployee())) {
            return false;
        }
        return true;
    }

}
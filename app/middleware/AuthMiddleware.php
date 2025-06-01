<?php

namespace app\middleware;

use app\service\AuthService\Auth;

class AuthMiddleware implements IMiddleware {
    public function handle($request, $next) {

        Auth::authorize();
        return $next($request);
    }
}
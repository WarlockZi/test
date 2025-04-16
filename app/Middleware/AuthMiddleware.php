<?php

namespace app\Middleware;

use app\Services\AuthService\Auth;

class AuthMiddleware implements IMiddleware {
    public function handle($request, $next) {

        Auth::authorize();
        return $next($request);
    }
}
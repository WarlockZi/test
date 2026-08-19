<?php

namespace app\middleware;

use app\service\AuthService\AuthService;

class AuthMiddleware implements IMiddleware {
    public function handle($request, $next) {

        AuthService::authorize();
        return $next($request);
    }
}
<?php

namespace app\Middleware;

class CartMiddleware implements IMiddleware {
    public function handle($request, $next) {

        return $next($request);
    }
}
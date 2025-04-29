<?php

namespace app\middleware;

class CartMiddleware implements IMiddleware {
    public function handle($request, $next) {

        return $next($request);
    }
}
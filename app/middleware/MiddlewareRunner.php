<?php
declare(strict_types=1);

namespace app\middleware;

class MiddlewareRunner {
    private array $middlewares = [];

    public function addMiddleware(IMiddleware $middleware): void
    {
        $this->middlewares[] = $middleware;
    }

    public function run($request, $finalHandler) {
        $handler = array_reduce(
            array_reverse($this->middlewares),
            function ($next, $middleware) {
                return function ($request) use ($middleware, $next) {
                    return $middleware->handle($request, $next);
                };
            },
            $finalHandler
        );

        return $handler($request);
    }
}
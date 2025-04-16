<?php

namespace app\Middleware;

interface IMiddleware
{
    public function handle($request, $next);
}
<?php

namespace app\middleware;

interface IMiddleware
{
    public function handle($request, $next);
}
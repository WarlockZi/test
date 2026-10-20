<?php

namespace app\middleware;
class CsrfMiddleware implements IMiddleware
{
    public function handle($request, $next)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $next($request);
        }

        $excludedPaths = ['/api/webhook', '/api/public', '/auth/yandex'];
        if (in_array($_SERVER['REQUEST_URI'], $excludedPaths)) {
            $next($request);
        }
        if (in_array($_SERVER['REDIRECT_URL'], $excludedPaths)) {
            $next($request);
        }

        $token = $_POST['csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';

//        error_log('post - ' . $_POST['csrf_token']);
        error_log('server - ' . $_SERVER['HTTP_X_CSRF_TOKEN']);

        if (!validateCsrfToken($token)) {
            response('CSRF validation failed', 403)->consoleLog('CSRF validation failed');
        }

        regenerateCsrfToken();
        return $next($request);
    }
}
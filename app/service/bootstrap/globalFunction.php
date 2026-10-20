<?php

use app\blade\View;
use app\service\Fs\FS;
use app\service\Response;
use app\service\Session;
use JetBrains\PhpStorm\NoReturn;


if (!function_exists('image')) {
    function image($path = ''): string
    {
        $nophoto = PIC_SERVICE . "nophoto-min.jpg";
        if (!$path) return $nophoto;
        $imagePath = env("PIC_PRODUCT") . $path;
        return is_readable(ROOT . $imagePath) && is_file(ROOT . $imagePath)
            ? $imagePath
            : $nophoto;
    }
}
if (!function_exists('response')) {
    function response($content = '', $status = 200, array $headers = []): Response
    {
        return new Response($content, $status, $headers);
    }
}
if (!function_exists('session')) {
    function session(): Session
    {
        return new Session();
    }
}
if (!function_exists('storage_path')) {
    function storage_path(): string
    {
        return FS::platformSlashes(ROOT . '/storage/');
    }
}
if (!function_exists('view')) {
    #[NoReturn]
    function view(string $view = null, array $data = [], int $status = 200, array $headers = []): void
    {
        $start = microtime(true);

        $blade    = APP->get(View::class);
        $content  = $blade->render($view, $data);
        $response = new Response($content, $status, $headers);

        $time = microtime(true) - $start;
//        error_log("Blade rendering time: " . round($time * 1000, 2) . " ms");

        $response->send();
    }
}


if (!function_exists('generateCsrfToken')) {

    function generateCsrfToken(): string
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    function validateCsrfToken(string $token): bool
    {
        if (!isset($_SESSION['csrf_token'])) {
            return false;
        }
        // Используем timing-safe сравнение для предотвращения атак по времени
        return hash_equals($_SESSION['csrf_token'], $token);
    }

    function regenerateCsrfToken(): void
    {
        unset($_SESSION['csrf_token']);
        generateCsrfToken();
    }
}
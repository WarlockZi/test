<?php

use app\service\Response;
use JetBrains\PhpStorm\NoReturn;
use app\blade\View;


function measureExecutionTime(callable $function, ...$args) {
    $startTime = microtime(true);
    call_user_func_array($function, $args);
    $endTime = microtime(true);
    $executionTime = round(($endTime - $startTime) * 1000, 2); // milliseconds
    return "Execution time: $executionTime ms";
}

if (!function_exists('response')) {
    function response($content = '', $status = 200, array $headers = []): Response
    {
        return new Response($content, $status, $headers);
    }
}

if (!function_exists('view')) {

    #[NoReturn] function view(string $view = null, array $data = []): \Illuminate\Contracts\View\Factory|View
    {
        $factory = APP->get(View::class);
        exit($factory->render($view, $data));
    }
}
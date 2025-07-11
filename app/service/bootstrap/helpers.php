<?php

use app\blade\IView;
use app\blade\View;
use app\decorator\LogExecutionTime;
use app\service\Response;
use JetBrains\PhpStorm\NoReturn;


if (!function_exists('response')) {
    function response($content = '', $status = 200, array $headers = []): Response
    {
        return new Response($content, $status, $headers);
    }
}

if (!function_exists('view')) {
    #[LogExecutionTime]
    #[NoReturn]
    function view(string $view = null, array $data = [], int $status = 200, array $headers = []): \Illuminate\Contracts\View\Factory|View
    {
        $factory = APP->get(IView::class);
        exit($factory->render($view, $data, $status, $headers));
    }
}
<?php

use app\blade\IView;
use app\blade\View;
use app\service\Response;
use JetBrains\PhpStorm\NoReturn;

if (!function_exists('image')) {
    function image($path = ''): string
    {
        $imagePath = env("PIC_PRODUCT") . $path;
        return is_readable(ROOT.$imagePath)&&is_file(ROOT.$imagePath)
            ? $imagePath
            : PIC_SERVICE . "nophoto-min.jpg";
    }
}
if (!function_exists('response')) {
    function response($content = '', $status = 200, array $headers = []): Response
    {
        return new Response($content, $status, $headers);
    }
}

if (!function_exists('view')) {
    #[NoReturn]
    function view(string $view = null, array $data = [], int $status = 200, array $headers = [])
    {
        $blade = APP->get(View::class);
        $content= $blade->render($view, $data);
        $response =  new Response($content, $status, $headers);
        $response->send();
    }
}
<?php

namespace app\middleware;

use app\service\AuthService\Auth;
use app\service\Response;

class ProductMainImageMiddleware implements IMiddleware
{
    public function handle($request, $next)
    {

        $this->validateSize($request->files['size']);
        $this->validateType($request->files['type']);
        return $next($request);
    }

    private function validateSize(int $size): void
    {
        $allowed = 30;
        $message = "File size must be less than {$allowed} mb";
        if ($size > $allowed * 1024 * 1024) Response::exitWithPopup($message);
    }

    private function validateType(string $type): void
    {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];

        $allowedStirng = implode(',', $allowed);
        $allowedArray = array_map(function ($item){
            return 'image/'.$item;
        },$allowed);

        $message = "Тип файла должен быть {$allowedStirng}";
        if (in_array($type, $allowedArray)) Response::exitWithPopup($message);

    }
}
<?php

use app\core\Router;
use app\model\Category;

session_start();
$_SESSION['phpSession'] = session_id();

require_once __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php';

try {
//    $user = Auth::getUser();
//	$mockUser = \app\model\User::query()->find(160);
//	$Olya = \app\model\User::query()
//        ->where('email', 'vitex018@yandex.ru')
//        ->first();
//	Auth::setUser($Olya);

//    Cat();
    $router = new Router($_SERVER['REQUEST_URI'] ?? '');
    $router->dispatch();
    exit();
} catch (Throwable $e) {
    if ($_ENV['DEV'] === '0') {
        $logger = new \app\Services\Logger\ErrorLogger();
        $logger->write($e);
    }
    exit($e);
}

function Cat(): void
{
    Category::with('parent')->get()->each(function (Category $category) {
        $path = [];
        if (!$category->parent) {
            $category->ownProperties->path = '';
            $category->ownProperties->save();
        } else {
            $localCategory = $category;
            while ($category->parent) {
                $path[]   = $category->parent->slug;
                $category = $category->parent;
            }
            $str                                = implode('/', array_reverse($path));
            $localCategory->ownProperties->path = $str;
            $localCategory->ownProperties->save();
            echo $localCategory->ownProperties->path;
        }
    });
}


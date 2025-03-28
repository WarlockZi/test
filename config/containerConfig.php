<?php
declare(strict_types=1);

use app\controller\CartController;
use app\Repository\CartRepository;
use app\Repository\OrderitemRepository;
use app\Repository\OrderRepository;
use app\Services\Logger\ErrorLogger;
use app\Services\Logger\FileLogger;
use app\Services\Router\Router;
use app\view\Cart\CartView;
use function DI\create;

return [
    'Router' => new Router($_SERVER['REQUEST_URI'] ?? ''),

    'ErrorLogger' => new ErrorLogger(),
    'ImportLogger' => new FileLogger(),

    OrderRepository::class => new OrderRepository(),
    OrderitemRepository::class => new OrderitemRepository(),

    CartController::class => create()->constructor(
        DI\get(CartView::class), DI\get(CartRepository::class)
    ),

];
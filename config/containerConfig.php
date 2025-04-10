<?php
declare(strict_types=1);

use app\controller\AppController;
use app\controller\CartController;
use app\Repository\BlueRibbonRepository;
use app\Repository\CartRepository;
use app\Repository\CategoryRepository;
use app\Repository\OrderitemRepository;
use app\Repository\OrderRepository;
use app\Services\AssetsService\UserAssets;
use app\Services\CatalogMobileMenu\CatalogMobileMenuService;
use app\Services\FS;
use app\Services\Logger\ErrorLogger;
use app\Services\Logger\FileLogger;
use app\Services\Router\Route;
use app\Services\Router\Router;
use app\view\blade\Blade;
use app\view\blade\IView;
use app\view\blade\View;
use app\view\Cart\CartView;
use app\view\components\Header\BlueRibbon\BlueRibbon;
use app\view\components\Header\UserHeader;
use app\view\Icon;
use app\view\layouts\MainLayout;
use Psr\Container\ContainerInterface;
use function DI\autowire;
use function DI\create;
use function DI\get;
use function DI\value;

return [
    CatalogMobileMenuService::class => create()->constructor(
        get(View::class),
        value(''),
        value(CategoryRepository::treeAll()->toArray()),
    ),

    'mobileCategories'=>CategoryRepository::treeAll()->toArray(),

    AppController::class => function (ContainerInterface $c) {
        return new AppController();
    },

    Route::class => autowire(),

    IView::class => get(View::class),
    View::class => autowire(),

    MainLayout::class => autowire(MainLayout::class),
    Blade::class => autowire(Blade::class),

    'rootCategories' => function (ContainerInterface $c) {
        return CategoryRepository::rootCategories();
    },

    'oItemsCount' => OrderRepository::count(),
    'logo' => function () {
        return Icon::logo_square1() . Icon::logo_vitex1();
    },

    UserHeader::class => autowire(),

    FS::class => create()->constructor(
        ROOT, get(ErrorLogger::class)
    ),
    Router::class => create()->constructor(
        $_SERVER['REQUEST_URI'] ?? '',
        get(ErrorLogger::class)),

    ErrorLogger::class => create()->constructor('errors/errors.txt'),
    FileLogger::class => create()->constructor(),

    OrderRepository::class => create()->constructor(),
    OrderitemRepository::class => create()->constructor(),

    CartRepository::class => create()->constructor(),
    CartView::class => create()->constructor(),
    UserAssets::class => create(UserAssets::class),

    BlueRibbon::class => create(BlueRibbon::class)
        ->constructor(
            get(View::class),
            get(BlueRibbonRepository::class)
        ),
    CartController::class => create()->constructor(
        get(CartView::class),
        get(CartRepository::class),
        get(UserAssets::class),
        get(Route::class),
    ),

];

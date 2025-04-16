<?php
declare(strict_types=1);

use app\controller\AppController;
use app\controller\CartController;
use app\Exceptions\AppErrorHandler;
use app\Repository\BlueRibbonRepository;
use app\Repository\CartRepository;
use app\Repository\CategoryRepository;
use app\Repository\OrderitemRepository;
use app\Repository\OrderRepository;
use app\Services\AssetsService\UserAssets;
use app\Services\Cache\Cache;
use app\Services\CatalogMobileMenu\CatalogMobileMenuService;
use app\Services\FS;
use app\Services\Logger\ErrorLogger;
use app\Services\Logger\FileLogger;
use app\Services\Router\Route;
use app\Services\Router\Router;
use app\view\blade\Blade;
use app\view\blade\IView;
use app\view\blade\View as BladeView;
use app\view\Cart\CartView;
use app\view\components\Header\BlueRibbon\BlueRibbon;
use app\view\components\Header\UserHeader;
use app\view\Icon;
use app\view\layouts\MainLayout;
use Psr\Container\ContainerInterface;
use function DI\autowire;
use function DI\create;
use function DI\factory;
use function DI\get;
use function DI\value;

return [

    Cache::class => function (ContainerInterface $container) {
        return Cache::getInstance(env('CACHE'));
    },
    CatalogMobileMenuService::class => create()->constructor(
        get(BladeView::class),
        value(''),
        value(CategoryRepository::treeAll()->toArray()),
    ),

    'mobileCategories' => CategoryRepository::treeAll()->toArray(),

    'bladeView' => create(BladeView::class)
        ->constructor(create(Blade::class)
            ->constructor(create(FS::class)
                ->constructor(ROOT, create(ErrorLogger::class)
                    ->constructor('error')
                )
            )
        ),


    AppController::class => function (ContainerInterface $c) {
        return new AppController();
    },

    IView::class => get(BladeView::class),
    BladeView::class => autowire(),


    MainLayout::class => autowire(),
    Blade::class => autowire(Blade::class),

    'rootCategories' => function (ContainerInterface $c) {
        return CategoryRepository::rootCategories();
    },

    'oItemsCount' => OrderRepository::count(),
    'logo' => function () {
        return Icon::logo_square1() . Icon::logo_vitex1();
    },

    UserHeader::class => autowire(),
    AppErrorHandler::class => function (ContainerInterface $c) {
        return new AppErrorHandler(
            $c->get(ErrorLogger::class)
        );
    },

    FS::class => create()->constructor(
        ROOT, get(ErrorLogger::class)
    ),

    'uri' => $_SERVER['REQUEST_URI'],

    Router::class => factory(function (ContainerInterface $c) {
        return new Router(
            $_SERVER['REQUEST_URI'],
            $c->get(ErrorLogger::class),
        );
    }),


    ErrorLogger::class => create()->constructor('errors/errors.txt'),
    FileLogger::class => create()->constructor(),

    OrderRepository::class => create()->constructor(),
    OrderitemRepository::class => create()->constructor(),

    CartRepository::class => create()->constructor(),
    CartView::class => create()->constructor(),
    UserAssets::class => create(UserAssets::class),

    BlueRibbon::class => create(BlueRibbon::class)
        ->constructor(
            get(BladeView::class),
            get(BlueRibbonRepository::class)
        ),
    CartController::class => create()->constructor(
        get(CartView::class),
        get(CartRepository::class),
        get(UserAssets::class),
        get(Route::class),
    ),

];

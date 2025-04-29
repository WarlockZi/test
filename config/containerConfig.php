<?php
declare(strict_types=1);

use app\controller\AppController;
use app\controller\CartController;
use app\controller\Controller;
use app\exception\AppErrorHandler;
use app\repository\BlueRibbonRepository;
use app\repository\CartRepository;
use app\repository\CategoryRepository;
use app\repository\OrderitemRepository;
use app\repository\OrderRepository;
use app\service\AssetsService\UserAssets;
use app\service\CatalogMobileMenu\CatalogMobileMenuService;
use app\service\FS;
use app\service\Logger\ErrorLogger;
use app\service\Logger\FileLogger;
use app\service\Router\IRequest;
use app\service\Router\IRouteList;
use app\service\Router\Request;
use app\service\Router\RouteList;
use app\service\Router\Router;
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
    IRequest::class => function () {
        return Request::capture();
    },

    IRouteList::class => function (ContainerInterface $container) {
        return new RouteList();
    },

    CatalogMobileMenuService::class => create()->constructor(
        get(BladeView::class),
        value(''),
        value(CategoryRepository::treeAll()->toArray()),
    ),

    Controller::class => create()->constructor(),
    'mobileCategories' => CategoryRepository::treeAll()->toArray(),

    AppController::class => function (ContainerInterface $c) {
        return new AppController();
    },

    IView::class => get(BladeView::class),
    MainLayout::class => autowire(),
    BladeView::class => autowire(),
    Blade::class => autowire(),
    'bladeView' => function (ContainerInterface $c) {
        return new BladeView($c->get(Blade::class));
    },

    'rootCategories' => function (ContainerInterface $c) {
        return CategoryRepository::rootCategories();
    },

    'oItemsCount' => OrderRepository::count(),
    'logo' => function () {
        return Icon::logo_square1() . Icon::logo_vitex1();
    },

    UserHeader::class=>autowire(),
    AppErrorHandler::class => function (ContainerInterface $c) {
        return new AppErrorHandler(
            $c->get(ErrorLogger::class)
        );
    },

    FS::class => factory(function ($dir, $logger) {
        return new FS($dir, $logger);
    })->parameter('dir', ROOT)
        ->parameter('logger', get(FileLogger::class)),

    'uri' => $_SERVER['REQUEST_URI'],

    Router::class => factory(function (ContainerInterface $c) {
        return new Router(
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
        get(Request::class),
    ),
    //    UserHeader::class => function (ContainerInterface $c) {
//        return new UserHeader(
//            $c->get(IRequest::class),
//            $c->get(BlueRibbon::class),);
//    },
];

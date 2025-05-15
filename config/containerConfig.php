<?php
declare(strict_types=1);

use app\action\CategoryAction;
use app\controller\AppController;
use app\controller\CartController;
use app\controller\Controller;
use app\exception\AppErrorHandler;
use app\repository\BlueRibbonRepository;
use app\repository\CartRepository;
use app\repository\CategoryRepository;
use app\repository\OrderRepository;
use app\service\CatalogMobileMenu\CatalogMobileMenuService;
use app\service\FS;
use app\service\Logger\ErrorLogger;
use app\service\Logger\FileLogger;
use app\service\Router\IRequest;
use app\service\Router\IRouteList;
use app\service\Router\Request;
use app\service\Router\RouteList;
use app\service\Router\Router;
use app\blade\Blade;
use app\blade\IView;
use app\blade\View as BladeView;
use app\view\Cart\CartView;
use app\view\components\Header\BlueRibbon\BlueRibbon;
use app\view\layouts\AdminLayout;
use app\view\layouts\ILayout;
use app\view\layouts\MainLayout;
use Psr\Container\ContainerInterface;
use function DI\autowire;
use function DI\create;
use function DI\factory;
use function DI\get;
use function DI\value;

return [

    CategoryAction::class=>autowire(),

    IRequest::class => Request::capture(),

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
    ILayout::class => function (ContainerInterface $c) {
        if ($c->get(IRequest::class)->isAdmin()) {
            return $c->get(AdminLayout::class);
        }else{
            return $c->get(MainLayout::class);
        }
    },

    BladeView::class => autowire(),
    Blade::class => autowire(),


    'rootCategories' => function (ContainerInterface $c) {
        return CategoryRepository::rootCategories();
    },

    'oItemsCount' => OrderRepository::count(),


    AppErrorHandler::class => function (ContainerInterface $c) {
        return new AppErrorHandler(
            $c->get(ErrorLogger::class)
        );
    },

    FS::class => factory(function ($dir, $logger) {
        return new FS($dir, $logger);
    })->parameter('dir', ROOT)
        ->parameter('logger', get(FileLogger::class)),

    Router::class => factory(function (ContainerInterface $c) {
        return new Router(
            $c->get(ErrorLogger::class),
        );
    }),

    ErrorLogger::class => create()->constructor('errors/errors.txt'),
    FileLogger::class => create()->constructor(),

    BlueRibbon::class => create(BlueRibbon::class)
        ->constructor(
            get(BladeView::class),
            get(BlueRibbonRepository::class)
        ),
    CartController::class => create()->constructor(
        get(CartView::class),
        get(CartRepository::class),
        get(Request::class),
    ),
];

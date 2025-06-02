<?php
declare(strict_types=1);

use app\blade\Blade;
use app\blade\IView;
use app\blade\View;
use app\repository\CategoryRepository;
use app\repository\OrderRepository;
use app\service\DB\Eloquent;
use app\service\DelCatalogMobileMenu\CatalogMobileMenuService;
use app\service\FS;
use app\service\Logger\ErrorLogger;
use app\service\Logger\FileLogger;
use app\service\Router\IRequest;
use app\service\Router\IRouteList;
use app\service\Router\Request;
use app\service\Router\RouteList;
use app\service\Router\Router;
use app\view\layouts\AdminLayout;
use app\view\layouts\ILayout;
use app\view\layouts\MainLayout;
use Illuminate\Database\Capsule\Manager as Capsule;
use Psr\Container\ContainerInterface;
use function DI\autowire;
use function DI\create;
use function DI\factory;
use function DI\get;
use function DI\value;

return [

    View::class => function(ContainerInterface $c) {
            return new View(new Blade());
    },
//    ShippableUnitsService::class => function ($c, $module, $model) {
//        return new ShippableUnitsService($module, $model);
//    },

    Eloquent::class => function () {
        return new Eloquent(new Capsule);
    },

//    CategoryAction::class => autowire(),

    IRequest::class => function () {
        return Request::capture();
    },

    IRouteList::class => function () {
        return new RouteList();
    },

    CatalogMobileMenuService::class => create()->constructor(
        get(View::class),
        value(''),
        value(CategoryRepository::treeAll()->toArray()),
    ),
    'mobileCategories' => CategoryRepository::treeAll()->toArray(),
    'rootCategories' => function (ContainerInterface $c) {
        return CategoryRepository::rootCategories();
    },

    'orderItemsCount' => OrderRepository::count(),

//    Controller::class => create()->constructor(),

//    AppController::class => function () {
//        return new AppController();
//    },


    ILayout::class => function (ContainerInterface $c) {
        if ($c->get(IRequest::class)->isAdmin()) {
            return $c->get(AdminLayout::class);
        } else {
            return $c->get(MainLayout::class);
        }
    },

//    BladeView::class => autowire(),
    Blade::class => create(Blade::class),


//    AppErrorHandler::class => function (ContainerInterface $c) {
//        return new AppErrorHandler(
//            $c->get(ErrorLogger::class)
//        );
//    },

    FS::class => function (ContainerInterface $c, $dir) {
        return new FS($dir . DIRECTORY_SEPARATOR,
            $c->get(FileLogger::class),);
    },


    Router::class => factory(function (ContainerInterface $c) {
        return new Router(
            $c->get(ErrorLogger::class),
        );
    }),

    ErrorLogger::class => create()->constructor('errors.txt'),
//    FileLogger::class => create()->constructor(),

//    BlueRibbon::class => create(BlueRibbon::class)
//        ->constructor(
//            get(BladeView::class),
//            get(BlueRibbonRepository::class)
//        ),

//    CartController::class => create()->constructor(
//        get(CartView::class),
//        get(CartRepository::class),
//        get(Request::class),
//    ),

];

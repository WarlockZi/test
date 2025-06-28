<?php
declare(strict_types=1);

use app\blade\Blade;
use app\blade\IView;
use app\blade\View;
use app\repository\OrderRepository;
use app\service\AdminSidebar\AdminSidebar;
use app\service\AuthService\Auth;
use app\service\Cache\ICache;
use app\service\Cache\Redis\Cache;
use app\service\FS;
use app\service\Logger\ErrorLogger;
use app\service\Logger\FileLogger;
use app\service\Router\IRequest;
use app\service\Router\IRouteList;
use app\service\Router\Request;
use app\service\Router\RouteList;
use app\service\Router\Router;
use app\service\Vite\Vite;
use app\service\Vite\ViteCompiler;
use app\view\components\Footer\AdminFooter;
use app\view\layouts\Admin\AdminLayout;
use app\view\layouts\Main\Header\MainHeader;
use app\view\layouts\Main\MainLayout;
use app\views\layouts\Main\Footer\MainFooter;
use Illuminate\Database\Capsule\Manager as Capsule;
use Predis\Client;
use Psr\Container\ContainerInterface;
use function DI\autowire;
use function DI\create;
use function DI\get;

return [


    Redis::class => function () {
        return new Client(
            [
                'scheme' => 'tcp',
                'host' => '127.0.0.1',
                'port' => 6379,
            ]
        );
    },

    ICache::class => function () {
        return Cache::getInstance();
    },

    Vite::class => create(Vite::class)
        ->constructor(get(ViteCompiler::class)),

    MainLayout::class => function (ContainerInterface $c) {
        return new MainLayout(
            new MainHeader,
            new MainFooter,
        );
    },


    AdminLayout::class => function () {
        return new AdminLayout(
            new AdminSidebar(
                Auth::getUser(),
                []
            )
        );
    },

    AdminFooter::class => autowire(),
    'db.config' => [
        'driver' => 'mysql',
        'host' => 'localhost',
        'database' => env('DB_DB'),
        'username' => env('DB_USER'),
        'password' => env('DB_PASSWORD'),
        'charset' => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix' => '',
    ],


    Capsule::class => function (ContainerInterface $c) {
        $capsule = new Capsule;
        $capsule->addConnection($c->get('db.config'));
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
        return $capsule;
    },


    IView::class => function (ContainerInterface $c) {
        return new View(
            new Blade(),
            $c->get(IRequest::class)
        );
    },

    IRequest::class => function () {
        return Request::capture();
    },

    IRouteList::class => function () {
        return new RouteList();
    },

    'orderItemsCount' => function () {
        return OrderRepository::count();
    },

    Blade::class => create(Blade::class),

    FS::class => function (ContainerInterface $c, $dir) {
        return new FS($dir . DIRECTORY_SEPARATOR,
            $c->get(FileLogger::class),);
    },

    ErrorLogger::class => create()
        ->constructor('errors.txt'),

    Router::class => function (ContainerInterface $c) {
        return new Router(
            $c->get(ErrorLogger::class),
            $c->get(IRequest::class),
        );
    },
];

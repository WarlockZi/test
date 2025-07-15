<?php
declare(strict_types=1);

namespace app\service\AppService;


use app\service\Cache\ICache;
use app\service\Router\Router;
use DI\DependencyException;
use DI\NotFoundException;
use Exception;
use Illuminate\Database\Capsule\Manager as Capsule;


class App
{
    /**
     * @throws NotFoundException
     * @throws DependencyException
     * @throws Exception
     */
    public function __construct()
    {
        $container = new Container();

        var_dump($container);
        define('APP', $container());
        var_dump('------- app -----');
        var_dump(APP);

        APP->get(Capsule::class);

        $cache = APP->get(ICache::class);
        $cache::enabled(env('CACHE'));

    }

    public function handleRequest(): void
    {
        APP->get(Router::class)->dispatch();
    }
}
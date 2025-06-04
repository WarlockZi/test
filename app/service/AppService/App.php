<?php
declare(strict_types=1);

namespace app\service\AppService;


use app\service\Cache\Cache;
use app\service\DB\Eloquent;
use app\service\Router\Router;
use DI\DependencyException;
use DI\NotFoundException;
use Exception;
use Redis;


class App
{

    /**
     * @throws NotFoundException
     * @throws DependencyException
     * @throws Exception
     */
    public function __construct()
    {
        new Eloquent();
        define('APP', (new Container())());
        Cache::$enabled = env('CACHE');

        $client = new \Predis\Client(
            [
                'scheme' => 'tcp',
                'host'   => '127.0.0.1',
                'port'   => 6379,
            ]
        );
        $client->set('foo', 'bar');
        $value = $client->get('foo');
        echo $value; // выведет "bar"
//        $redis          = new Redis();
//        $con            = $redis->connect('127.0.0.1', 6379);
        if ($client) {

        }

    }

    public function handleRequest(): void
    {
        APP->get(Router::class)->dispatch();
    }

}
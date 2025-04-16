<?php
declare(strict_types=1);

namespace app\Services\AppService;


use app\Request\Request;
use app\Services\Cache\Cache;
use app\Services\DB\Eloquent;
use app\Services\Router\Router;
use DI\DependencyException;
use DI\NotFoundException;
use Illuminate\Database\Capsule\Manager as Capsule;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class App
{

    private ContainerInterface $container;

    /**
     * @throws NotFoundException
     * @throws DependencyException
     * @throws \Exception
     */
    public function __construct()
    {
        $this->container = (new AppService())();
        new Eloquent(new Capsule);
        Cache::$enabled = env('CACHE');
    }

    public function handleRequest(Request $request): void
    {
        $router = APP->get(Router::class);
        $router->dispatch($request);
    }
    public function run(): void
    {
        define('APP', $this);
    }
    /**
     * @throws NotFoundExceptionInterface
     * @throws NotFoundException
     * @throws ContainerExceptionInterface
     * @throws DependencyException
     */
    public function get(string $id)
    {
        return $this->container->get($id);
    }

    public function has(string $id): ?bool
    {
        return $this->container->has($id);
    }
}
<?php
declare(strict_types=1);

namespace app\service\AppService;


use app\service\Cache\Cache;
use app\service\DB\Eloquent;
use app\service\Router\IRequest;
use app\service\Router\Router;
use DI\DependencyException;
use DI\NotFoundException;
use Exception;
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
     * @throws Exception
     */
    public function __construct()
    {
        new Eloquent(new Capsule);
        $this->container = (new AppService())();
        Cache::$enabled = env('CACHE');
    }

    public function handleRequest(): void
    {
        $request = APP->get(IRequest::class);
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

    /**
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function make(string $name, array $params = [])
    {
        return $this->container->make($name, $params);
    }
    public function call(array $name, array $params = [])
    {
        return $this->container->call($name, $params);
    }

}
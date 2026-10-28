<?php

namespace app\service\AppService;

use app\service\Fs\FS;
use DI\ContainerBuilder;
use Exception;
use function DI\create;

class Container
{
    private \DI\Container $container;
    /**
     * @throws Exception
     */
    public function __construct()
    {
        $containerCompiled = FS::platformSlashes(
            ROOT . '/storage/framework/container/CompiledContainer.php'
        );

        $containerPath = ROOT . '/storage/framework/container';
        if (!is_writable($containerPath)) {// should be 777
            throw new Exception("Container path is not writable");
        }
        $builder = new ContainerBuilder();

        $builder->addDefinitions(ROOT . '/config/containerConfig.php');
        $builder->addDefinitions(['\app\controller\*::class' => create()]);

        if (!DEV) {
            $builder->enableCompilation($containerPath);
        }
        $builder->useAutowiring(true);

        $this->container =  $builder->build();
    }

    public function get(string $name){
        return $this->container->get($name);
    }
    public function call(array $callable, array $parameters=[] ){
        return $this->container->call($callable, $parameters);
    }
}
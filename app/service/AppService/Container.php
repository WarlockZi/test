<?php

namespace app\service\AppService;

use app\service\FS;
use DI\ContainerBuilder;
use Exception;
use function DI\autowire;
use function DI\create;

class Container
{
    /**
     * @throws Exception
     */
    public function __invoke()
    {
        $containerCompiled =
            FS::platformSlashes(
                ROOT . '/storage/framework/container/CompiledContainer.php'
            );
//        if (is_readable($containerCompiled)) {
//            unlink($containerCompiled);
//        }

        $container = new ContainerBuilder();

        $container->addDefinitions([
            '\app\controller\*::class' => create()
        ]);

        $container
            ->addDefinitions('../config/containerConfig.php')
            ->useAutowiring(true)
            ->enableCompilation(ROOT . '/storage/framework/container');


        return $container->build();
    }
}
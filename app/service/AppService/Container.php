<?php

namespace app\service\AppService;

use app\service\Fs\FS;
use DI\ContainerBuilder;
use Exception;
use function DI\create;

class Container
{
    /**
     * @throws Exception
     */
    public function __invoke(): \DI\Container
    {
        $containerCompiled = FS::platformSlashes(
            ROOT . '/storage/framework/container/CompiledContainer.php'
        );
//        if (is_readable($containerCompiled)) {
//            unlink($containerCompiled);
//        }

        $containerPath = ROOT . '/storage/framework/container';
        if (!is_writable($containerPath)) {// should be 777
            throw new Exception("Container path is not writable");
        }
        $container = new ContainerBuilder();

        $container->addDefinitions(ROOT . '/config/containerConfig.php');
        $container->addDefinitions(['\app\controller\*::class' => create()]);

        if (!DEV) {
            $container->enableCompilation($containerPath);
        }
        $container->useAutowiring(true);

        return $container->build();
    }
}
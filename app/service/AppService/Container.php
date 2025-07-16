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
    public function __invoke()
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

        $container->addDefinitions('../config/containerConfig.php');
        $container->addDefinitions(['\app\controller\*::class' => create()]);

        $container
            ->useAutowiring(true)
            ->enableCompilation($containerPath);

        return $container->build();
    }
}
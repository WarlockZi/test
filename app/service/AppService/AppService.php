<?php

namespace app\service\AppService;

use app\service\FS;
use DI\ContainerBuilder;
use Exception;

class AppService
{
    /**
     * @throws Exception
     */
    public function __invoke()
    {
        $containerCompiled =
            FS::platformSlashes(ROOT . '/storage/framework/container/CompiledContainer.php');
//        if (is_readable($containerCompiled)) {
//            unlink($containerCompiled);
//        }

        return (new ContainerBuilder())

            ->addDefinitions('../config/containerConfig.php')
            ->useAutowiring(true)
            ->enableCompilation(ROOT . '/storage/framework/container')
            ->build();
    }
}
<?php

namespace app\service\AppService;

use DI\ContainerBuilder;
use Exception;

class AppService
{
    /**
     * @throws Exception
     */
    public function __invoke()
    {
        if (!env('CACHE_CONTAINER')) {
            $containerCompiled = ROOT . '../../storage/framework/container/CompiledContainer.php';
            if (is_readable($containerCompiled)) {
                unlink($containerCompiled);
            }
        }

        return env('CACHE_CONTAINER')
            ? (new ContainerBuilder())
                ->addDefinitions('../config/containerConfig.php')
                ->build()
            : (new ContainerBuilder())
                ->addDefinitions('../config/containerConfig.php')
                ->enableCompilation(ROOT . '/storage/framework/container')
                ->build();
    }
}
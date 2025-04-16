<?php

namespace app\Services\AppService;

use DI\ContainerBuilder;
use Exception;

class AppService
{
    /**
     * @throws Exception
     */
    public function __invoke()
    {
        if (DEV) {
            $containerCompiled = ROOT . '../../storage/framework/container/CompiledContainer.php';
            if (is_readable($containerCompiled)) {
                unlink($containerCompiled);
            }
        }

        return DEV
            ? (new ContainerBuilder())
                ->addDefinitions('../config/containerConfig.php')
                ->build()
            : (new ContainerBuilder())
                ->addDefinitions('../config/containerConfig.php')
                ->enableCompilation(ROOT . '/storage/framework/container')
                ->build();
    }
}
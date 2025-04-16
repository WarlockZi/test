<?php

namespace app\Services\AppService;

use DI\ContainerBuilder as Container;
use Psr\Container\ContainerInterface;
use Throwable;

class ContainerBuilder
{
    public function __invoke(): ContainerBuilder
    {
        try {
            $containerCompiled = ROOT . '/storage/framework/container/CompiledContainer.php';
            if (is_readable($containerCompiled)) {
                unlink($containerCompiled);
            }

            return (new Container())
                ->addDefinitions('../config/containerConfig.php')
//        ->enableCompilation(ROOT . '/storage/framework/container')
                ->build();

        } catch (Throwable $exception) {
            $exc = $exception;
            return new ContainerBuilder();
        }
    }


}

<?php

use DI\ContainerBuilder;

try {
    $containerCompiled = ROOT . '/storage/framework/container/CompiledContainer.php';
    if (is_readable($containerCompiled)) {
        unlink($containerCompiled);
    }
    return $container = (new ContainerBuilder())
        ->addDefinitions('../config/containerConfig.php')
//        ->enableCompilation(ROOT . '/storage/framework/container')
        ->build();
} catch (Throwable $exception) {
    $exc = $exception;
}
<?php

use DI\ContainerBuilder;

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions('../config/containerConfig.php');
try {
    return $container = $containerBuilder->build();
} catch (Throwable $exception) {
    $exc = $exception;
}
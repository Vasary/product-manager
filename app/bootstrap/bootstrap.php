<?php

use DI\ContainerBuilder;
use Slim\Factory\AppFactory;

define('APPLICATION_NAME', 'product-manager');

$containerBuilder = new ContainerBuilder();
$containerBuilder->useAnnotations(true);

$forceCompile = true === getenv('FORCE_CONTAINER_COMPILE');
$compilableEnvironment = in_array(getenv('ENVIRONMENT'), ['prod', 'staging'], true);

if ($compilableEnvironment || $forceCompile) {
    $containerBuilder->enableCompilation('/var/application/cache');
}

parameters($containerBuilder);
injectDependencies($containerBuilder);

try {
    $container = $containerBuilder->build();
} catch (Throwable $throwable) {
    renderUnhandledErrorResponse($throwable, 'DI builder context');
    exit(1);
}

AppFactory::setContainer($container);

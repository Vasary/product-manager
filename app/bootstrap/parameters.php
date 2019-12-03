<?php

declare(strict_types=1);

use DI\ContainerBuilder;

use function DI\env;

/**
 * @param ContainerBuilder $containerBuilder
 */
function parameters(ContainerBuilder $containerBuilder): void
{
    $containerBuilder->addDefinitions([
        'app.version'       => env('CI_COMMIT_REF_NAME', 'develop'),
        'app.environment'   => env('ENVIRONMENT', 'dev'),
    ]);
}

<?php

use Doctrine\ORM\EntityManagerInterface;
use Slim\Factory\AppFactory;
use Slim\Middleware\ContentLengthMiddleware;
use Vasary\ProductManager\Service\ErrorHandler;

require_once __DIR__ . '/../bootstrap/bootstrap.php';

$app = AppFactory::create();

middleware($app);
routes($app);

$app->addRoutingMiddleware();
$app->add(new ContentLengthMiddleware());
$app->addBodyParsingMiddleware();

$doShowErrors = 'prod' !== getenv('ENVIRONMENT');

$errorMiddleware = $app->addErrorMiddleware($doShowErrors, true, true);

if (null !== $app->getContainer()) {
    $errorMiddleware->setDefaultErrorHandler($app->getContainer()->get(ErrorHandler::class));

    // Begin transaction
    $app->getContainer()->get(EntityManagerInterface::class)->beginTransaction();
}

try {
    $app->run();
} catch (Throwable $throwable) {
    renderUnhandledErrorResponse($throwable, 'Application error');
    exit(1);
}

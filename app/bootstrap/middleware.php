<?php

declare(strict_types=1);

use Doctrine\ORM\EntityManagerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Log\LoggerInterface;
use Slim\App;

/**
 * @param App $app
 */
function middleware(App $app): void
{
    $responseLogger = function (Request $request, RequestHandler $handler) use ($app) {
        $response = $handler->handle($request);

        if (null !== $app->getContainer()) {
            $message = sprintf('HTTP Response code: %s', $response->getStatusCode());

            $app->getContainer()->get(LoggerInterface::class)->info($message, $response->getHeaders());
            $app->getContainer()->get(LoggerInterface::class)->info($response->getBody()->getContents());
        }

        return $response;
    };

    $transactionFinalizer = function (Request $request, RequestHandler $handler) use ($app) {
        $response = $handler->handle($request);

        if (null !== $app->getContainer()) {
            $app->getContainer()->get(LoggerInterface::class)->info('Preparing for commit');
            $app->getContainer()->get(EntityManagerInterface::class)->flush();
            $app->getContainer()->get(EntityManagerInterface::class)->commit();
            $app->getContainer()->get(LoggerInterface::class)->info('Transaction committed');
        }

        return $response;
    };

    /**
     * Callable middleware handling in the end of application life cycle. Order is important
     */
    $app->add($transactionFinalizer);
    $app->add($responseLogger);
}

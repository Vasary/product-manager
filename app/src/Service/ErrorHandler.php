<?php

namespace Vasary\ProductManager\Service;

use Fig\Http\Message\StatusCodeInterface;
use Monolog\Processor\UidProcessor;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Slim\Interfaces\ErrorHandlerInterface;
use Throwable;
use Vasary\ProductManager\Service\Response\JsonResponse;

/**
 * Class ErrorHandler
 * @package Vasary\ProductManager\Service
 */
final class ErrorHandler implements ErrorHandlerInterface
{
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var UidProcessor
     */
    private UidProcessor $uidProcessor;

    /**
     * ErrorHandler constructor.
     * @param LoggerInterface $logger
     * @param UidProcessor $uidProcessor
     */
    public function __construct(LoggerInterface $logger, UidProcessor $uidProcessor)
    {
        $this->logger = $logger;
        $this->uidProcessor = $uidProcessor;
    }

    /**
     * @param ServerRequestInterface $request
     * @param Throwable $exception
     * @param bool $displayErrorDetails
     * @param bool $logErrors
     * @param bool $logErrorDetails
     * @return ResponseInterface
     */
    public function __invoke(
        ServerRequestInterface $request,
        Throwable $exception,
        bool $displayErrorDetails,
        bool $logErrors,
        bool $logErrorDetails
    ): ResponseInterface
    {
        if ($logErrors) {
            $this->logger->error($exception->getMessage());
        }

        if ($logErrorDetails) {
            $this->logger->info('Trace', $exception->getTrace());
        }

        $baseDataBlock = [
            'message' => 'Something went wrong',
            'session' => $this->uidProcessor->getUid(),
        ];

        if ($displayErrorDetails) {
            $baseDataBlock['error'] = $exception->getMessage();
        }

        return JsonResponse::create($baseDataBlock, StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR);
    }
}

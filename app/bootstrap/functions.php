<?php

declare(strict_types=1);

use Fig\Http\Message\StatusCodeInterface;
use Monolog\Formatter\LogstashFormatter;
use Vasary\ProductManager\Enum\StatusMessage;

/**
 * @param Throwable $throwable
 * @param string $message
 */
function renderUnhandledErrorResponse(Throwable $throwable, string $message): void
{
    http_response_code(StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR);
    header('Content-type: application/json');

    logError(StatusMessage::ERROR, $throwable->getCode(), $message, $throwable->getMessage());
}

/**
 * @return void
 */
function shutdown(): void
{
    $error = error_get_last();

    if (null !== $error && E_ERROR === $error['type']) {
        $message = "{$error['message']} in {$error['file']} on {$error['line']} line";

        logError(StatusMessage::ERROR, 1, $message, 'Shutdown');
    }
}

/**
 * @param string $status
 * @param int $code
 * @param string $message
 * @param string $description
 * @return void
 */
function logError(string $status, int $code, string $message, string $description): void
{
    $data = [
        'status' => $status,
        'code' => $code,
        'message' => $message,
        'description' => $description
    ];

    $message = json_encode($data, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE, 512);

    $logStashFormatter = new LogstashFormatter(APPLICATION_NAME);

    echo $message . PHP_EOL;

    error_log((string)$logStashFormatter->format($data), 0);
}

/**
 * @param $errorNumber
 * @param $errorString
 * @param $errorFile
 * @param $errorLine
 */
function error($errorNumber, $errorString, $errorFile, $errorLine): void
{
    if (E_ERROR !== $errorNumber) {
        return;
    }

    http_response_code(StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR);

    $message = $errorString . ' [' . $errorNumber . '] ' . $errorString . " in {$errorFile}:{$errorLine}";

    logError(StatusMessage::ERROR, 1, $message, 'Error');
}

<?php

declare(strict_types=1);

use Fig\Http\Message\StatusCodeInterface;

date_default_timezone_set('Europe/Moscow');

require_once __DIR__ . '/../vendor/autoload.php';

register_shutdown_function(static function () {
    shutdown();

    if (!headers_sent()) {
        http_response_code(StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR);
    }
});

set_error_handler(static function ($number, $string, $file, $line) {
    error($number, $string, $file, $line);
});

set_exception_handler(static function (Throwable $throwable) {
    renderUnhandledErrorResponse($throwable, 'Exception handler');
});

require_once '../src/Application.php';

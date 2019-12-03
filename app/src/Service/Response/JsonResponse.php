<?php

namespace Vasary\ProductManager\Service\Response;

use Fig\Http\Message\StatusCodeInterface;
use RuntimeException;
use Slim\Psr7\Headers;
use Slim\Psr7\Response;
use Slim\Psr7\Stream;

/**
 * Class JsonResponse
 * @package Vasary\ProductManager\Service\Response
 */
final class JsonResponse extends Response
{
    /**
     * @param array $body
     * @param int $statusCode
     * @return Response
     *
     * @throws RuntimeException
     */
    public static function create(array $body = [], int $statusCode = StatusCodeInterface::STATUS_OK): Response
    {
        $tmp = fopen('php://temp', 'w+b');

        if (false === $tmp) {
            throw new RuntimeException('Can not create output context');
        }

        $stream = new Stream($tmp);
        $stream->write(json_encode($body, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE));

        $headers =
            new Headers(
                [
                    'Content-Type'      => 'application/json',
                    'Facility'          => 'Product-management service'
                ]
            )
        ;

        $stream->seek(0);

        return new Response($statusCode, $headers, $stream);
    }
}

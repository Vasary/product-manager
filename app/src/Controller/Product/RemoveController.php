<?php

namespace Vasary\ProductManager\Controller\Product;

use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Vasary\ProductManager\Handler\ProductRemoveHandler;
use Vasary\ProductManager\Service\Response\JsonResponse;

/**
 * Class RemoveController
 * @package Vasary\ProductManager\Controller\Product
 */
final class RemoveController
{
    /**
     * @var ProductRemoveHandler
     */
    private ProductRemoveHandler $handler;

    /**
     * ReadController constructor.
     * @param ProductRemoveHandler $handler
     */
    public function __construct(ProductRemoveHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $arguments
     *
     * @return Response
     *
     */
    public function __invoke(Request $request, Response $response, array $arguments): ResponseInterface
    {
        $this->handler->handle($arguments['id']);

        return JsonResponse::create();
    }
}

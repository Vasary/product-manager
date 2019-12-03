<?php

namespace Vasary\ProductManager\Controller\Product;

use Psr\Http\Message\ResponseInterface;
use ReflectionException;
use Slim\Psr7\Request;
use Vasary\ProductManager\Handler\ProductUpdateHandler;
use Vasary\ProductManager\Service\Response\JsonResponse;
use Vasary\ProductManager\Service\Serializer\Serializer;

/**
 * Class UpdateController
 * @package Vasary\ProductManager\Controller\Product
 */
final class UpdateController
{
    /**
     * @var ProductUpdateHandler
     */
    private ProductUpdateHandler $handler;

    /**
     * @var Serializer
     */
    private Serializer $serializer;

    /**
     * CreateController constructor.
     * @param ProductUpdateHandler $handler
     * @param Serializer $serializer
     */
    public function __construct(ProductUpdateHandler $handler, Serializer $serializer)
    {
        $this->handler = $handler;
        $this->serializer = $serializer;
    }

    /**
     * @param Request $request
     * @param ResponseInterface $response
     * @param array $arguments
     * @return ResponseInterface
     * @throws ReflectionException
     */
    public function __invoke(Request $request, ResponseInterface $response, array $arguments): ResponseInterface
    {
        return
            JsonResponse::create(
                $this->serializer->serializeObject(
                    $this->handler->handle(
                        $arguments['id'],
                        $request->getParsedBody()
                    )
                )
            )
        ;
    }
}

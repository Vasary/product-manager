<?php

namespace Vasary\ProductManager\Controller\Product;

use JMS\Serializer\ArrayTransformerInterface;
use JMS\Serializer\SerializerInterface;
use Psr\Http\Message\ResponseInterface;
use ReflectionException;
use Slim\Psr7\Request;
use Vasary\ProductManager\Handler\ProductUpdateHandler;
use Vasary\ProductManager\Service\Response\JsonResponse;

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
     * @var SerializerInterface | ArrayTransformerInterface
     */
    private SerializerInterface $serializer;

    /**
     * CreateController constructor.
     * @param ProductUpdateHandler $handler
     * @param SerializerInterface $serializer
     */
    public function __construct(ProductUpdateHandler $handler, SerializerInterface $serializer)
    {
        $this->handler = $handler;
        $this->serializer = $serializer;
    }

    /**
     * @param Request $request
     * @param ResponseInterface $response
     * @param array $arguments
     * @return ResponseInterface
     */
    public function __invoke(Request $request, ResponseInterface $response, array $arguments): ResponseInterface
    {
        return
            JsonResponse::create(
                $this->serializer->toArray($this->handler->handle($request->getParsedBody()))
            )
        ;
    }
}

<?php

namespace Vasary\ProductManager\Controller\Product;

use Psr\Http\Message\ResponseInterface;
use ReflectionException;
use Vasary\ProductManager\Handler\ProductListHandler;
use Vasary\ProductManager\Service\Response\JsonResponse;
use Vasary\ProductManager\Service\Serializer\Serializer;

/**
 * Class ListController
 * @package Vasary\ProductManager\Controller\Product
 */
final class ListController
{
    /**
     * @var ProductListHandler
     */
    private ProductListHandler $handler;

    /**
     * @var Serializer
     */
    private Serializer $serializer;

    /**
     * ReadController constructor.
     * @param ProductListHandler $handler
     * @param Serializer $serializer
     */
    public function __construct(ProductListHandler $handler, Serializer $serializer)
    {
        $this->handler = $handler;
        $this->serializer = $serializer;
    }

    /**
     * @return ResponseInterface
     * @throws ReflectionException
     */
    public function __invoke(): ResponseInterface
    {
        return JsonResponse::create($this->serializer->serializeCollection($this->handler->handle()));
    }
}

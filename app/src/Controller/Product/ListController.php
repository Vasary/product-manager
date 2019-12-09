<?php

namespace Vasary\ProductManager\Controller\Product;

use JMS\Serializer\ArrayTransformerInterface;
use JMS\Serializer\SerializerInterface;
use Psr\Http\Message\ResponseInterface;
use Vasary\ProductManager\Handler\ProductListHandler;
use Vasary\ProductManager\Service\Response\JsonResponse;

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
     * @var SerializerInterface | ArrayTransformerInterface
     */
    private SerializerInterface $serializer;

    /**
     * ReadController constructor.
     * @param ProductListHandler $handler
     * @param SerializerInterface $serializer
     */
    public function __construct(ProductListHandler $handler, SerializerInterface $serializer)
    {
        $this->handler = $handler;
        $this->serializer = $serializer;
    }

    /**
     * @return ResponseInterface
     */
    public function __invoke(): ResponseInterface
    {
        return JsonResponse::create($this->serializer->toArray($this->handler->handle()));
    }
}

<?php

namespace Vasary\ProductManager\Controller\Product;

use JMS\Serializer\ArrayTransformerInterface;
use JMS\Serializer\SerializerInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Vasary\ProductManager\Handler\ProductCreateHandler;
use Vasary\ProductManager\Service\Response\JsonResponse;

/**
 * Class ProductManager
 * @package Vasary\ProductManager\Controller\Product
 */
final class CreateController
{
    /**
     * @var ProductCreateHandler
     */
    private ProductCreateHandler $handler;

    /**
     * @var SerializerInterface | ArrayTransformerInterface
     */
    private SerializerInterface $serializer;

    /**
     * CreateController constructor.
     * @param ProductCreateHandler $handler
     * @param SerializerInterface $serializer
     */
    public function __construct(ProductCreateHandler $handler, SerializerInterface $serializer)
    {
        $this->handler = $handler;
        $this->serializer = $serializer;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request): ResponseInterface
    {
        return JsonResponse::create($this->serializer->toArray($this->handler->handle($request->getParsedBody())));
    }
}

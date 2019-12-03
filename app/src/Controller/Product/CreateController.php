<?php

namespace Vasary\ProductManager\Controller\Product;

use Psr\Http\Message\ResponseInterface;
use ReflectionException;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Vasary\ProductManager\Handler\ProductCreateHandler;
use Vasary\ProductManager\Service\Response\JsonResponse;
use Vasary\ProductManager\Service\Serializer\Serializer;

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
     * @var Serializer
     */
    private Serializer $serializer;

    /**
     * CreateController constructor.
     * @param ProductCreateHandler $handler
     * @param Serializer $serializer
     */
    public function __construct(ProductCreateHandler $handler, Serializer $serializer)
    {
        $this->handler = $handler;
        $this->serializer = $serializer;
    }

    /**
     * @param Request $request
     * @return Response
     * @throws ReflectionException
     */
    public function __invoke(Request $request): ResponseInterface
    {
        return JsonResponse::create($this->serializer->serializeObject($this->handler->handle($request->getParsedBody())));
    }
}

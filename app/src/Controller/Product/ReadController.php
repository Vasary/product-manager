<?php

namespace Vasary\ProductManager\Controller\Product;

use Psr\Http\Message\ResponseInterface;
use ReflectionException;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Vasary\ProductManager\Handler\ProductReadHandler;
use Vasary\ProductManager\Service\Response\JsonResponse;
use Vasary\ProductManager\Service\Serializer\Serializer;
use Webmozart\Assert\Assert;

/**
 * Class ReadController
 * @package Vasary\ProductManager\Controller\Product
 */
final class ReadController
{
    /**
     * @var ProductReadHandler
     */
    private ProductReadHandler $handler;

    /**
     * @var Serializer
     */
    private Serializer $serializer;

    /**
     * ReadController constructor.
     * @param ProductReadHandler $handler
     * @param Serializer $serializer
     */
    public function __construct(ProductReadHandler $handler, Serializer $serializer)
    {
        $this->handler = $handler;
        $this->serializer = $serializer;
    }

    /**
     * @param Request $request
     * @param Response $response
     * @param array $arguments
     *
     * @return Response
     *
     * @throws ReflectionException
     */
    public function __invoke(Request $request, Response $response, array $arguments): ResponseInterface
    {
        Assert::keyExists($arguments, 'id');
        Assert::greaterThan($arguments['id'], 0);

        return JsonResponse::create($this->serializer->serializeObject($this->handler->handle($arguments['id'])));
    }
}

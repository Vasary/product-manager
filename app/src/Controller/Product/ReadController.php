<?php

namespace Vasary\ProductManager\Controller\Product;

use JMS\Serializer\ArrayTransformerInterface;
use JMS\Serializer\SerializerInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Vasary\ProductManager\Handler\ProductReadHandler;
use Vasary\ProductManager\Service\Response\JsonResponse;
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
     * @var SerializerInterface | ArrayTransformerInterface
     */
    private SerializerInterface $serializer;

    /**
     * ReadController constructor.
     * @param ProductReadHandler $handler
     * @param SerializerInterface $serializer
     */
    public function __construct(ProductReadHandler $handler, SerializerInterface $serializer)
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
     */
    public function __invoke(Request $request, Response $response, array $arguments): ResponseInterface
    {
        Assert::keyExists($arguments, 'id');
        Assert::greaterThan($arguments['id'], 0);

        return JsonResponse::create($this->serializer->toArray($this->handler->handle($arguments['id'])));
    }
}

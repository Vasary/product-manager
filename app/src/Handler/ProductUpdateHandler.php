<?php

namespace Vasary\ProductManager\Handler;

use Doctrine\ORM\EntityManagerInterface;
use InvalidArgumentException;
use JMS\Serializer\ArrayTransformerInterface;
use JMS\Serializer\SerializerInterface;
use ReflectionException;
use Vasary\ProductManager\Entity\Product;

/**
 * Class ProductUpdateHandler
 * @package Vasary\ProductManager\Handler
 */
final class ProductUpdateHandler
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @var SerializerInterface | ArrayTransformerInterface
     */
    private SerializerInterface $serializer;

    /**
     * ProductUpdateHandler constructor.
     * @param EntityManagerInterface $entityManager
     * @param SerializerInterface $serializer
     */
    public function __construct(EntityManagerInterface $entityManager, SerializerInterface $serializer)
    {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
    }

    /**
     * @param int $id
     * @param array $data
     * @return Product
     */
    public function handle(int $id, array $data): Product
    {
        $product = $this->findProduct($id);

        // $product = $this->serializer->fromArray($data, Product::class);

        var_dump($this->serializer->fromArray($data, Product::class)); exit;

        $this->entityManager->persist($product);

        return $product;
    }

    /**
     * @param int $id
     * @return Product
     */
    private function findProduct(int $id): Product
    {
        /** @var Product $product */
        $product = $this->entityManager->getRepository(Product::class)->find($id);

        if (null === $product) {
            throw new InvalidArgumentException('Product does not exists');
        }

        return $product;
    }
}

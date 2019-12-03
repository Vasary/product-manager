<?php

namespace Vasary\ProductManager\Handler;

use Doctrine\ORM\EntityManagerInterface;
use InvalidArgumentException;
use ReflectionException;
use Vasary\ProductManager\Entity\Product;
use Vasary\ProductManager\Service\Serializer\Serializer;

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
     * @var Serializer
     */
    private Serializer $serializer;

    /**
     * ProductUpdateHandler constructor.
     * @param EntityManagerInterface $entityManager
     * @param Serializer $serializer
     */
    public function __construct(EntityManagerInterface $entityManager, Serializer $serializer)
    {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
    }

    /**
     * @param int $id
     * @param array $data
     * @return Product
     * @throws ReflectionException
     */
    public function handle(int $id, array $data): Product
    {
        $product = $this->findProduct($id);

        $this->serializer->update($product, $data);

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

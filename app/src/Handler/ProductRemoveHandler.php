<?php

namespace Vasary\ProductManager\Handler;

use Doctrine\ORM\EntityManagerInterface;
use InvalidArgumentException;
use Vasary\ProductManager\Entity\Product;

/**
 * Class ProductRemoveHandler
 * @package Vasary\ProductManager\Handler
 */
final class ProductRemoveHandler
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * ProductRemoveHandler constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param int $id
     */
    public function handle(int $id): void
    {
        $this->entityManager->remove($this->getProductById($id));
    }

    /**
     * @param int $id
     * @return Product
     */
    private function getProductById(int $id): Product
    {
        $product = $this->entityManager->getRepository(Product::class)->find($id);

        if (null === $product) {
            throw new InvalidArgumentException('Product not found');
        }

        /** @var Product $product */
        return $product;
    }
}

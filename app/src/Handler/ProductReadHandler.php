<?php

namespace Vasary\ProductManager\Handler;

use Doctrine\ORM\EntityManagerInterface;
use InvalidArgumentException;
use Vasary\ProductManager\Entity\Product;

/**
 * Class ProductReadHandler
 * @package Vasary\ProductManager\Handler
 */
final class ProductReadHandler
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * ProductReadHandler constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param int $id
     * @return Product
     */
    public function handle(int $id): Product
    {
        $product = $this->entityManager->getRepository(Product::class)->find($id);

        if (null === $product) {
            throw new InvalidArgumentException('Product not found');
        }

        /** @var Product $product */
        return $product;
    }
}

<?php

namespace Vasary\ProductManager\Handler;

use Doctrine\ORM\EntityManagerInterface;
use Vasary\ProductManager\Entity\Product;

/**
 * Class ProductListHandler
 * @package Vasary\ProductManager\Handler
 */
final class ProductListHandler
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * ProductListHandler constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return array
     */
    public function handle(): array
    {
        return $this->entityManager->getRepository(Product::class)->findAll();
    }
}

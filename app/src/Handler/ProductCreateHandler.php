<?php

namespace Vasary\ProductManager\Handler;

use Doctrine\ORM\EntityManagerInterface;
use Vasary\ProductManager\Entity\Product;
use Webmozart\Assert\Assert;

/**
 * Class ProductCreateHandler
 * @package Vasary\ProductManager\Handler
 */
final class ProductCreateHandler
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * ProductCreateHandler constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param array $data
     * @return Product
     */
    public function handle(array $data): Product
    {
        $this->validate($data);
        $product = $this->spawnProduct($data);

        $this->entityManager->persist($product);

        return $product;
    }

    /**
     * @param array $data
     * @return Product
     */
    private function spawnProduct(array $data): Product
    {
        return new Product($data['name'], $data['description']);
    }

    /**
     * @param array $data
     */
    private function validate(array $data): void
    {
        Assert::keyExists($data, 'name');
        Assert::keyExists($data, 'description');
    }
}

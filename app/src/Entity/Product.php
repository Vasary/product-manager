<?php

namespace Vasary\ProductManager\Entity;

use Doctrine\ORM\Mapping as ORM;
use Vasary\ProductManager\Annotation\Serializer;
use Webmozart\Assert\Assert;

/**
 * @ORM\Entity(repositoryClass="Doctrine\ORM\EntityRepository")
 * @ORM\Table(name="products")
 */
class Product
{
    /**
     * @var int|null
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     *
     * @Serializer(type="integer", name="id")
     */
    private ?int $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="name")
     *
     * @Serializer(type="string", name="name")
     */
    private string $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="description")
     *
     * @Serializer(type="string", name="description")
     */
    private string $description;

    /**
     * Product constructor.
     * @param string $name
     * @param string $description
     */
    public function __construct(string $name, string $description)
    {
        Assert::lengthBetween($name, 1, 255);
        Assert::minLength($description, 1);

        $this->name = $name;
        $this->description = $description;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
}

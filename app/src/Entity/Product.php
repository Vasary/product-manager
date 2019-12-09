<?php

namespace Vasary\ProductManager\Entity;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;
use JMS\Serializer\Annotation as Serializer;

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
     * @Serializer\SerializedName("id")
     * @Serializer\Type("integer")
     */
    private ?int $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="name")
     *
     * @Serializer\SerializedName("name")
     * @Serializer\Type("string")
     */
    private string $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="description")
     *
     * @Serializer\SerializedName("description")
     * @Serializer\Type("string")
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

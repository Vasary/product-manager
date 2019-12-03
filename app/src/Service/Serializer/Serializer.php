<?php

namespace Vasary\ProductManager\Service\Serializer;

use Doctrine\Common\Annotations\Reader;
use ReflectionClass;
use ReflectionException;
use Vasary\ProductManager\Annotation\Serializer as SerializerAnnotation;

/**
 * Class Serializer
 * @package Vasary\ProductManager\Service\Serializer
 */
final class Serializer
{
    /**
     * @var Reader
     */
    private Reader $reader;

    /**
     * Serializer constructor.
     * @param Reader $annotationReader
     */
    public function __construct(Reader $annotationReader)
    {
        $this->reader = $annotationReader;
    }

    /**
     * @param object $object
     * @return array
     * @throws ReflectionException
     */
    public function serializeObject(object $object): array
    {
        $reflectionClass = new ReflectionClass($object);

        $result = [];

        foreach ($reflectionClass->getProperties() as $property) {

            /** @var SerializerAnnotation $annotation */
            $annotation = $this->reader->getPropertyAnnotation($property, SerializerAnnotation::class);

            $property->setAccessible(true);

            $result[$annotation->name] = $property->getValue($object);
        }

        return $result;
    }

    /**
     * @param array $list
     * @return array
     * @throws ReflectionException
     */
    public function serializeCollection(array $list = []): array
    {
        $result = [];

        foreach ($list as $key => $value) {
            /** @var object $value */
            $result[$key] = $this->serializeObject($value);
        }

        return $result;
    }

    /**
     * @param object $object
     * @param array $data
     * @throws ReflectionException
     */
    public function update(object $object, array $data): void
    {
        $reflectionClass = new ReflectionClass($object);

        foreach ($data as $propertyName => $propertyValue) {
            $property = $reflectionClass->getProperty($propertyName);
            $property->setAccessible(true);

            $property->setValue($object, $propertyValue);
        }
    }
}

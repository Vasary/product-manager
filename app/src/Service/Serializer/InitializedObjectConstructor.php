<?php

namespace Vasary\ProductManager\Service\Serializer;

use JMS\Serializer\Construction\ObjectConstructorInterface;
use JMS\Serializer\DeserializationContext;
use JMS\Serializer\Metadata\ClassMetadata;
use JMS\Serializer\Visitor\DeserializationVisitorInterface;

/**
 * Class InitializedObjectConstructor
 */
class InitializedObjectConstructor implements ObjectConstructorInterface
{
    private ObjectConstructorInterface $fallbackConstructor;

    /**
     * @param ObjectConstructorInterface $fallbackConstructor Fallback object constructor
     */
    public function __construct(ObjectConstructorInterface $fallbackConstructor)
    {
        $this->fallbackConstructor = $fallbackConstructor;
    }

    /**
     * {@inheritdoc}
     */
    public function construct(
        DeserializationVisitorInterface $visitor,
        ClassMetadata $metadata,
        $data,
        array $type,
        DeserializationContext $context
    ): ?object {
        if ($context->hasAttribute('target') && 1 === $context->getDepth()) {
            return $context->getAttribute('target');
        }

        return $this->fallbackConstructor->construct($visitor, $metadata, $data, $type, $context);
    }
}

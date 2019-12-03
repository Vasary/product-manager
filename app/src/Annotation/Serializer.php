<?php

namespace Vasary\ProductManager\Annotation;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Target({"PROPERTY"})
 */
class Serializer
{
    /**
     * @var string
     */
    public string $name;

    /**
     * @var string
     */
    public string $type;
}

<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use JMS\Serializer\Annotation as Serializer;
use Vasary\ProductManager\Service\ORM\EntityManagerProvider;

class_exists(Serializer\Type::class);
class_exists(Serializer\SerializedName::class);

return ConsoleRunner::createHelperSet(EntityManagerProvider::build(getenv('DATABASE_URL')));

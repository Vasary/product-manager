<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Vasary\ProductManager\Annotation\Serializer;
use Vasary\ProductManager\Service\ORM\EntityManagerProvider;

class_exists(Serializer::class);

return ConsoleRunner::createHelperSet(EntityManagerProvider::build(getenv('DATABASE_URL')));

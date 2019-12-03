<?php

namespace Vasary\ProductManager\Service\ORM;

use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Tools\Setup;

/**
 * Class EntityManagerProvider
 * @package Vasary\ProductManager\Service\ORM
 */
final class EntityManagerProvider
{
    private const DOCTRINE_ENTITIES_DIR = ['/application/src/Entity'];

    private const DOCTRINE_PROXIES_DIR  = '/var/application/metadata/doctrine/proxies';
    private const DOCTRINE_CACHE        = '/var/application/metadata/doctrine/cache';

    /**
     * @param string $dsn
     * @return EntityManagerInterface
     * @throws ORMException
     */
    public static function build(string $dsn): EntityManagerInterface
    {
        $parameters = ['url' => $dsn];

        $config =
            Setup::createAnnotationMetadataConfiguration(
                self::DOCTRINE_ENTITIES_DIR,
                false,
                self::DOCTRINE_PROXIES_DIR,
                new FilesystemCache(self::DOCTRINE_CACHE),
                false
            )
        ;

        return EntityManager::create($parameters, $config);
    }
}

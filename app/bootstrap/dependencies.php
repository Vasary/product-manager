<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\Reader;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\Naming\IdenticalPropertyNamingStrategy;
use JMS\Serializer\Naming\SerializedNameAnnotationStrategy;
use JMS\Serializer\SerializerInterface;
use Monolog\Formatter\LogstashFormatter;
use Monolog\Handler\ErrorLogHandler;
use Monolog\Logger;
use Monolog\Processor\MemoryUsageProcessor;
use Monolog\Processor\UidProcessor;
use Monolog\Processor\WebProcessor;
use Psr\Log\LoggerInterface;
use Vasary\ProductManager\Service\ErrorHandler;
use Vasary\ProductManager\Service\Log\Processor\ExtraDataProcessor;
use Vasary\ProductManager\Service\ORM\EntityManagerProvider;

use function DI\autowire;
use function DI\create;
use function DI\get;

/**
 * @param ContainerBuilder $containerBuilder
 */
function injectDependencies(ContainerBuilder $containerBuilder): void
{
    $containerBuilder->addDefinitions([
        ErrorHandler::class        => autowire(ErrorHandler::class),

        /**
         * Logging processors
         */
        UidProcessor::class         => create(UidProcessor::class)->constructor(16),
        WebProcessor::class         => create(WebProcessor::class),
        MemoryUsageProcessor::class => create(MemoryUsageProcessor::class),
        ExtraDataProcessor::class   => create(ExtraDataProcessor::class)
                                        ->constructor(get('app.version')),

        /**
         * Logging handlers
         */
        ErrorLogHandler::class      => static function () {
            $handler = new ErrorLogHandler(ErrorLogHandler::OPERATING_SYSTEM, Logger::INFO);
            $handler->setFormatter(
                new LogstashFormatter(
                    APPLICATION_NAME,
                    gethostname(),
                    '',
                    '',
                    LogstashFormatter::V1
                )
            );

            return $handler;
        },

        /**
        * EntityManager
        */
        EntityManagerInterface::class => static function () {
            return EntityManagerProvider::build(getenv('DATABASE_URL'));
        },

        /**
        * Services
        */
        SerializerInterface::class => static function () {
            return
                JMS\Serializer\SerializerBuilder::create()
                    ->setPropertyNamingStrategy(
                        new SerializedNameAnnotationStrategy(
                            new IdenticalPropertyNamingStrategy()
                        )
                    )
                    ->build()
            ;
        },

        /**
         * Logging
         */
        LoggerInterface::class      => create(Logger::class)
                                        ->constructor(
                                            'API',
                                            [
                                                get(ErrorLogHandler::class),
                                            ],
                                            [
                                                get(UidProcessor::class),
                                                get(MemoryUsageProcessor::class),
                                                get(ExtraDataProcessor::class),
                                                get(WebProcessor::class),
                                            ]
                                        ),
    ]);
}

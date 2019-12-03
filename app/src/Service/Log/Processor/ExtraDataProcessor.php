<?php

namespace Vasary\ProductManager\Service\Log\Processor;

use Monolog\Processor\ProcessorInterface;

/**
 * Class ExtraDataProcessor
 * @package Vasary\ProductManager\Service\Log\Processor
 */
final class ExtraDataProcessor implements ProcessorInterface
{
    /**
     * @var string
     */
    private string $version;

    /**
     * VersionProcessor constructor.
     * @param string $version
     */
    public function __construct(string $version)
    {
        $this->version = $version;
    }

    /**
     * @param array $record
     * @return array
     */
    public function __invoke(array $record)
    {
        $record['extra']['application_version'] = $this->version;
        $record['extra']['php_version'] = PHP_VERSION;

        return $record;
    }
}

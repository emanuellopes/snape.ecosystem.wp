<?php

namespace Snape\EcoSystemWP\Config;

use League\Config\ConfigurationBuilderInterface;
use Snape\EcoSystemWP\Contracts\IConfigurationSchemaInterface;

trait ConfigReaderTrait
{
    protected function registerConfigSchema(
        IConfigurationSchemaInterface $config,
        ConfigurationBuilderInterface $configurationBuilder
    ): void {
        $configurationBuilder->addSchema(
            $config->getKey(),
            $config->getSchema()
        );
        $configurationBuilder->merge($config->getConfigFile());
    }
}

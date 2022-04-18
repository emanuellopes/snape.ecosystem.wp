<?php

namespace Snape\EcoSystemWP\Bootstrappers;

use League\Config\Configuration;
use League\Config\ConfigurationBuilderInterface;
use League\Config\ConfigurationInterface;
use Snape\EcoSystemWP\Config\ApplicationConfig;
use Snape\EcoSystemWP\Contracts\IApplicationInterface;
use Snape\EcoSystemWP\Contracts\IBootstrapInterface;

class LoadConfiguration implements IBootstrapInterface
{
    public function bootstrap(IApplicationInterface $application): void
    {
        $container = $application->getContainer();
        $config = new Configuration();
        $container->add(ConfigurationInterface::class, $config)->setAlias(
            ConfigurationBuilderInterface::class
        );
//        $container->add(ConfigurationBuilderInterface::class, $config); //TODO: check if this is necessary

        $applicationConfig = new ApplicationConfig($application);
        $config->addSchema($applicationConfig->getKey(), $applicationConfig->getSchema());
        $config->merge($applicationConfig->getConfigFile());

        $a = $config->get('app');
        d($a);
    }
}

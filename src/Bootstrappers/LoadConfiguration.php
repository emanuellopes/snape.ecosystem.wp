<?php

namespace Snape\EcoSystemWP\Bootstrappers;

use League\Config\Configuration;
use League\Config\ConfigurationBuilderInterface;
use League\Config\ConfigurationInterface;
use Snape\EcoSystemWP\Config\ApplicationConfig;
use Snape\EcoSystemWP\Contracts\IApplicationInterface;
use Snape\EcoSystemWP\Contracts\IBootstrapInterface;

class LoadConfiguration extends AbstractBootstrapBase implements IBootstrapInterface
{
    public function bootstrap(IApplicationInterface $application): void
    {
        $container = $application->getContainer();
        $config = new Configuration();
        $container->add(ConfigurationInterface::class, $config);
        $container->add(ConfigurationBuilderInterface::class, $config); //TODO: check if this is necessary

        $applicationConfig = new ApplicationConfig($application);

        $this->registerConfigSchema($applicationConfig, $config);
    }
}

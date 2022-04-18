<?php

namespace Snape\EcoSystemWP\Providers;

use League\Config\ConfigurationBuilderInterface;
use League\Config\ConfigurationInterface;
use League\Container\ServiceProvider\AbstractServiceProvider;
use Snape\EcoSystemWP\Config\ConfigReaderTrait;
use Snape\EcoSystemWP\Contracts\IApplicationInterface;
use Snape\EcoSystemWP\Contracts\IContainerInterface;

abstract class AbstractBaseServiceProvider extends AbstractServiceProvider
{
    use ConfigReaderTrait;

    public function register(): void
    {
        // TODO: Implement register() method.
    }

    public function provides(string $id): bool
    {
        return false;
    }

    protected function getConfig(): ConfigurationInterface
    {
        /** @var IContainerInterface $container */
        $container = $this->getContainer();

        return $container->getConfig();
    }

    public function getConfigurationBuilder(): ConfigurationBuilderInterface
    {
        /** @var IContainerInterface $container */
        $container = $this->getContainer();

        return $container->getConfigurationBuilder();
    }

    protected function getApplication(): IApplicationInterface
    {
        /** @var IContainerInterface $container */
        $container = $this->getContainer();

        /** @var IApplicationInterface $app */
        $app = $container->get(IApplicationInterface::class);

        return $app;
    }
}

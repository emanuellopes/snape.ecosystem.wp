<?php

namespace Snape\EcoSystemWP\Providers;

use League\Config\ConfigurationInterface;
use League\Container\ServiceProvider\AbstractServiceProvider;
use Snape\EcoSystemWP\Contracts\IContainerInterface;

abstract class AbstractBaseServiceProvider extends AbstractServiceProvider
{
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
}

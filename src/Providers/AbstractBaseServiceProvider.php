<?php

namespace Snape\EcoSystemWP\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;

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
}

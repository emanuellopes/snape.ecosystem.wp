<?php

namespace Snape\EcoSystemWP\Providers;

use Snape\EcoSystemWP\Contracts\IPostTypeFactoryInterface;
use Snape\EcoSystemWP\PostType\Factory;

class PostTypeServiceProvider extends AbstractBaseServiceProvider
{
    public function provides(string $id): bool
    {
        $services = [
            Factory::class,
            IPostTypeFactoryInterface::class
        ];

        return in_array($id, $services);
    }

    /**
     * Register new instance of timber.
     */
    public function register(): void
    {
        $factory = new Factory($this->getContainer());

        $this->getContainer()->add(
            IPostTypeFactoryInterface::class,
            $factory
        );
    }
}

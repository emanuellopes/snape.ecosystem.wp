<?php

namespace Snape\EcoSystemWP\Providers;

use Snape\EcoSystemWP\Contracts\Taxonomy\ITaxonomyFactoryInterface;
use Snape\EcoSystemWP\Taxonomy\Factory;

class TaxonomyServiceProvider extends AbstractBaseServiceProvider
{
    public function provides(string $id): bool
    {
        $services = [
            Factory::class,
            ITaxonomyFactoryInterface::class
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
            ITaxonomyFactoryInterface::class,
            $factory
        );
    }
}

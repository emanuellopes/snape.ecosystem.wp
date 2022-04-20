<?php

namespace Snape\EcoSystemWP\Providers;

use League\Container\ServiceProvider\BootableServiceProviderInterface;
use Timber\Timber;

class TimberServiceProvider extends AbstractBaseServiceProvider implements BootableServiceProviderInterface
{
    /**
     * Change some fields in timber after initialize class.
     */
    public function boot(): void
    {
        Timber::$dirname = $this->getConfig()->get('app.timber.views');
    }

    /**
     * Register new instance of timber.
     */
    public function register(): void
    {
        $this->getContainer()->addShared(Timber::class);
    }

    public function provides(string $id): bool
    {
        return $id === Timber::class;
    }
}

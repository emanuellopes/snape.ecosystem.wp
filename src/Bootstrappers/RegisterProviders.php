<?php

namespace Snape\EcoSystemWP\Bootstrappers;

use League\Container\ServiceProvider\ServiceProviderInterface;
use Snape\EcoSystemWP\Contracts\IApplicationInterface;
use Snape\EcoSystemWP\Contracts\IBootstrapInterface;

/**
 * Register the providers from config files.
 *
 * @package Endor\Application
 */
class RegisterProviders implements IBootstrapInterface
{
    /**
     * Initialize Exception handler tool.
     *
     * @param  IApplicationInterface  $application  Application with container.
     */
    public function bootstrap(IApplicationInterface $application): void
    {
        $container = $application->getContainer();
        /** @var array $providers */
        $providers = $container->getConfig()->get('app.providers');

        if (empty($providers)) {
            return;
        }

        /** @var ServiceProviderInterface[] $providers */
        foreach ($providers as $provider) {
            $container->addServiceProvider(new $provider);
        }
    }
}

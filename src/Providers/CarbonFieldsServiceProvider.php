<?php

namespace Snape\EcoSystemWP\Providers;

use Carbon_Fields\Carbon_Fields;
use League\Container\ServiceProvider\BootableServiceProviderInterface;
use Snape\EcoSystemWP\CarbonFields\CarbonFieldsFactory;
use Snape\EcoSystemWP\Contracts\ICarbonFieldsFactoryInterface;

/**
 * Class CarbonFieldsServiceProvider
 *
 * @package Endor\Providers
 */
class CarbonFieldsServiceProvider extends AbstractBaseServiceProvider implements BootableServiceProviderInterface
{
    public function provides(string $id): bool
    {
        $services = array(
            CarbonFieldsFactory::class,
            ICarbonFieldsFactoryInterface::class,
        );

        return in_array($id, $services);
    }

    /**
     * Register new instance of carbon fields.
     */
    public function register(): void
    {
        $this->getContainer()->add(ICarbonFieldsFactoryInterface::class, new CarbonFieldsFactory());
    }


    /**
     * Initializes the Carbon Fields.
     */
    public function boot(): void
    {
        add_action(
            'after_setup_theme',
            function () {
                Carbon_Fields::boot();
            }
        );
    }
}

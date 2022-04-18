<?php

namespace Snape\EcoSystemWP\Providers;

use League\Container\ServiceProvider\BootableServiceProviderInterface;
use Snape\EcoSystemWP\Config\ResetConfig;

class ResetServiceProvider extends AbstractBaseServiceProvider implements BootableServiceProviderInterface
{
    /**
     * Search for reset files
     */
    public function boot(): void
    {
        $configSchema = new ResetConfig($this->getApplication());
        $this->registerConfigSchema($configSchema, $this->getConfigurationBuilder());

        /** @var array $reset_list */
        $reset_list = $this->getConfig()->get('reset');

        if (empty($reset_list)) {
            return;
        }

        foreach ($reset_list as $reset) {
            $this->getContainer()->getNew($reset);
        }
    }
}

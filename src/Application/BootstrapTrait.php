<?php

namespace Snape\EcoSystemWP\Application;

use Snape\EcoSystemWP\Bootstrappers\LoadConfiguration;
use Snape\EcoSystemWP\Bootstrappers\RegisterProviders;

trait BootstrapTrait
{
    /**
     * Flag whether the application has been bootstrapped.
     *
     * @var boolean
     */
    protected bool $bootstrapped = false;

    /**
     * Get whether the application has been bootstrapped.
     *
     * @return boolean
     */
    public function isBootstrapped()
    {
        return $this->bootstrapped;
    }

    /**
     * Return the list of all bootstrappers.
     *
     * @return array
     */
    public function bootstrappers(): array
    {
        return array(
            LoadConfiguration::class,
            RegisterProviders::class,
        );
    }
}

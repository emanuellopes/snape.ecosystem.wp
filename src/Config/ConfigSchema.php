<?php

namespace Snape\EcoSystemWP\Config;

use Snape\EcoSystemWP\Contracts\IApplicationInterface;
use Snape\EcoSystemWP\Contracts\IConfigurationSchema;

abstract class ConfigSchema implements IConfigurationSchema
{
    protected IApplicationInterface $application;

    public function __construct(IApplicationInterface $application)
    {
        $this->application = $application;
    }

    /**
     * @return mixed
     */
    abstract public function getConfigFile();

    abstract public function getKey(): string;
}

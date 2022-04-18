<?php

namespace Snape\EcoSystemWP\Application;

use League\Config\ConfigurationBuilderInterface;
use League\Config\ConfigurationInterface;
use Snape\EcoSystemWP\Contracts\IContainerInterface;

class Container extends \League\Container\Container implements IContainerInterface
{
    public function getConfig(): ConfigurationInterface
    {
        return $this->get(ConfigurationInterface::class); // @phpstan-ignore-line
    }

    public function getConfigurationBuilder(): ConfigurationBuilderInterface
    {
        return $this->get(ConfigurationBuilderInterface::class); // @phpstan-ignore-line
    }
}

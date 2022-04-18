<?php

namespace Snape\EcoSystemWP\Application;

use League\Config\ConfigurationInterface;

class Container extends \League\Container\Container
{
    public function getConfig(): ConfigurationInterface
    {
        return $this->get(ConfigurationInterface::class);
    }
}

<?php

namespace Snape\EcoSystemWP\Contracts;

use League\Config\ConfigurationBuilderInterface;
use League\Config\ConfigurationInterface;
use Psr\Container\ContainerInterface;

interface IContainerInterface extends ContainerInterface
{
    public function getConfig(): ConfigurationInterface;

    public function getConfigurationBuilder(): ConfigurationBuilderInterface;
}

<?php

namespace Snape\EcoSystemWP\Contracts;

use League\Config\ConfigurationInterface;

interface IContainerInterface
{
    public function getConfig(): ConfigurationInterface;
}

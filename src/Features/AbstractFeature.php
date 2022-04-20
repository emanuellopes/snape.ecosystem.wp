<?php

namespace Snape\EcoSystemWP\Features;

use League\Config\ConfigurationInterface;
use Snape\EcoSystemWP\Contracts\IFeaturesBootInterface;

abstract class AbstractFeature implements IFeaturesBootInterface
{
    protected string $boundedContext;

    public function __construct(ConfigurationInterface $config)
    {
        $this->boundedContext = $config->get('app.boundedContext');
        $this->boot();
    }
}

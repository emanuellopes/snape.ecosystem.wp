<?php

namespace Snape\EcoSystemWP\Features;

use Snape\EcoSystemWP\Contracts\IFeaturesBootInterface;

abstract class AbstractFeature implements IFeaturesBootInterface
{
    public function __construct()
    {
        $this->boot();
    }
}

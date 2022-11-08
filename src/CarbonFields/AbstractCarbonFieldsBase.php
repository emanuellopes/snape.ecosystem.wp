<?php

namespace Snape\EcoSystemWP\CarbonFields;

use League\Config\ConfigurationInterface;
use Snape\EcoSystemWP\Contracts\ICarbonFieldsFactoryInterface;
use Snape\EcoSystemWP\Features\AbstractFeature;

abstract class AbstractCarbonFieldsBase extends AbstractFeature
{
    protected ICarbonFieldsFactoryInterface $carbonFieldsFactory;

    public function __construct(ConfigurationInterface $config, ICarbonFieldsFactoryInterface $carbonFieldsFactory)
    {
        $this->carbonFieldsFactory = $carbonFieldsFactory;
        parent::__construct($config);
    }
}

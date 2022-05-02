<?php

namespace Snape\EcoSystemWP\AdvancedCustomFields;

use League\Config\ConfigurationInterface;
use Snape\EcoSystemWP\Features\AbstractFeature;
use StoutLogic\AcfBuilder\FieldsBuilder;

abstract class AbstractAcfBase extends AbstractFeature
{
    private FieldsBuilder $fieldsBuilder;

    public function __construct(ConfigurationInterface $config)
    {
        parent::__construct($config);
    }

    protected function createACFFields(string $name): void
    {
        $this->fieldsBuilder = new FieldsBuilder($name);

        add_action('acf/init', function () {
            acf_add_local_field_group($this->fieldsBuilder->build());
        });
    }
}

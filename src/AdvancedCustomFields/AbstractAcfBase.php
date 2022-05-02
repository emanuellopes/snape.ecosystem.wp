<?php

namespace Snape\EcoSystemWP\AdvancedCustomFields;

use Snape\EcoSystemWP\Features\AbstractFeature;
use StoutLogic\AcfBuilder\FieldsBuilder;

abstract class AbstractAcfBase extends AbstractFeature
{
    protected function createACFFields(string $name): FieldsBuilder
    {
        $fieldsBuilder = new FieldsBuilder($name);

        add_action('acf/init', function () use ($fieldsBuilder) {
            acf_add_local_field_group($fieldsBuilder->build());
        });

        return $fieldsBuilder;
    }
}

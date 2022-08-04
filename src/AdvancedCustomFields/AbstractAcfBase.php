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

    /**
     * @param  array  $options ACFPage Options
     * @param  string  $name Name of form inside options page
     *
     * @return FieldsBuilder
     */
    protected function createACFFOptionsPage(array $options, string $name): FieldsBuilder
    {
        $fieldsBuilder = new FieldsBuilder($name);

        add_action('acf/init', function () use ($options, $fieldsBuilder) {
            acf_add_options_page($options);
            acf_add_local_field_group($fieldsBuilder->build());
        });

        return $fieldsBuilder;
    }
}

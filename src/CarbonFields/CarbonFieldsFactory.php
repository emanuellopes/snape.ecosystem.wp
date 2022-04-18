<?php

namespace Snape\EcoSystemWP\CarbonFields;

use Snape\EcoSystemWP\Contracts\ICarbonFieldsFactoryInterface;

class CarbonFieldsFactory implements ICarbonFieldsFactoryInterface
{
    /**
     * Return the container from carbonfields.
     *
     * @param callable $callback
     */
    public function create(callable $callback): void
    {
        add_action('carbon_fields_register_fields', $callback);
    }
}

<?php

namespace Snape\EcoSystemWP\Contracts;

interface ICarbonFieldsFactoryInterface
{
    public function create(callable $callback): void;
}

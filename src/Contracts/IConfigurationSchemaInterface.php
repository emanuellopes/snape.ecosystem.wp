<?php

namespace Snape\EcoSystemWP\Contracts;

use Nette\Schema\Schema;

interface IConfigurationSchemaInterface
{
    public function getSchema(): Schema;

    public function getKey(): string;

    public function getConfigFile();
}

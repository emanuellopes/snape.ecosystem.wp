<?php

namespace Snape\EcoSystemWP\Contracts;

use Nette\Schema\Schema;

interface IConfigurationSchema
{
    public function getSchema(): Schema;
}

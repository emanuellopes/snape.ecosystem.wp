<?php

namespace Snape\EcoSystemWP\Contracts;

use Snape\EcoSystemWP\Application\Container;

interface IApplicationInterface
{
    public function bootstrap(): void;

    public function getContainer(): Container;

    public function configPath(string $folder_name = 'config'): string;
}

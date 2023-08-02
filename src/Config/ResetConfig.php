<?php

namespace Snape\EcoSystemWP\Config;

use Nette\Schema\Expect;
use Nette\Schema\Schema;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class ResetConfig extends AbstractConfigSchema
{
    public function getSchema(): Schema
    {
        return Expect::list('string');
    }

    /**
     * @return array<string, mixed> $config
     */
    public function getConfigFile(): array
    {
        try {
            $data = Yaml::parseFile($this->application->configPath() . '/reset.yaml');

        } catch (ParseException $e) {
            error_log('Configuration file not found');

            return array();
        }

        return $data;
    }

    public function getKey(): string
    {
        return 'reset';
    }
}

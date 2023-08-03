<?php

namespace Snape\EcoSystemWP\Config;

use Nette\Schema\Expect;
use Nette\Schema\Schema;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;
use Timber\Helper;

class ResetConfig extends AbstractConfigSchema
{
    public function getSchema(): Schema
    {
        return Expect::list('string');
    }

    public function getConfigFile(): mixed
    {
        try {
            $data = Yaml::parseFile($this->application->configPath() . '/reset.yaml');
        } catch (ParseException $e) {
           Helper::warn($e->getMessage());

            return array();
        }

        return $data;
    }

    public function getKey(): string
    {
        return 'reset';
    }
}

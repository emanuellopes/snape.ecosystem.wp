<?php

namespace Snape\EcoSystemWP\Config;

use Nette\Schema\Expect;
use Nette\Schema\Schema;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;
use Timber\Helper;

class FeaturesConfig extends AbstractConfigSchema
{
    public function getSchema(): Schema
    {
        return Expect::structure([
            'admin' => Expect::arrayOf('string', 'string')->required(),
            'public' => Expect::arrayOf('string', 'string')->required(),
        ]);
    }

    public function getConfigFile(): mixed
    {
        try {
            $data = Yaml::parseFile($this->application->configPath() . '/features.yaml');
        } catch (ParseException $e) {
            Helper::warn($e->getMessage());

            return array();
        }

        return $data;
    }

    public function getKey(): string
    {
        return 'features';
    }
}

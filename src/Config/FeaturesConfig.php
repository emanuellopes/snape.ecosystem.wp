<?php

namespace Snape\EcoSystemWP\Config;

use Nette\Schema\Expect;
use Nette\Schema\Schema;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class FeaturesConfig extends AbstractConfigSchema
{
    public function getSchema(): Schema
    {
        return Expect::structure([
            'admin' => Expect::arrayOf('string', 'string')->required(),
            'public' => Expect::arrayOf('string', 'string')->required(),
        ]);
    }

    /**
     * @return array<string, mixed> $config
     */
    public function getConfigFile(): array
    {
        try {
            $data = Yaml::parseFile($this->application->configPath() . '/features.yaml');
        } catch (ParseException $e) {
            error_log('Configuration file not found');

            return array();
        }

        return $data;
    }

    public function getKey(): string
    {
        return 'features';
    }
}

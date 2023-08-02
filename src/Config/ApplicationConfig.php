<?php

namespace Snape\EcoSystemWP\Config;

use JsonException;
use Nette\Schema\Expect;
use Nette\Schema\Schema;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class ApplicationConfig extends AbstractConfigSchema
{
    public function getSchema(): Schema
    {
        return Expect::structure([
            'providers' => Expect::list('string')->required(),
            'timber' => Expect::structure([
                'viewsPath' => Expect::string()->default('views'),
                'alias' => Expect::arrayOf('string', 'string')
            ])->required(),
            'boundedContext' => Expect::string()->required(),
            'theme' => Expect::structure([
                'supports' => Expect::arrayOf(Expect::anyOf(Expect::bool(), Expect::array()), 'string'),
            ])->required(),
        ]);
    }

    /**
     * @return  array<string, mixed> $config
     */
    public function getConfigFile(): array
    {
        try {
            $data = Yaml::parseFile($this->application->configPath() . '/app.yaml');
        } catch (ParseException $e) {
            error_log('Configuration file not found');

            return array();
        }

        return $data;
    }

    public function getKey(): string
    {
        return 'app';
    }
}

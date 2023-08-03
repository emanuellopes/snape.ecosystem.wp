<?php

namespace Snape\EcoSystemWP\Config;

use Nette\Schema\Expect;
use Nette\Schema\Schema;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;
use Timber\Helper;

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

    public function getConfigFile(): mixed
    {
        try {
            $data = Yaml::parseFile($this->application->configPath() . '/app.yaml');
        } catch (ParseException $e) {
            Helper::warn($e->getMessage());

            return array();
        }

        return $data;
    }

    public function getKey(): string
    {
        return 'app';
    }
}

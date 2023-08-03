<?php

namespace Snape\EcoSystemWP\Config;

use Nette\Schema\Expect;
use Nette\Schema\Schema;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;
use Timber\Helper;

class ImagesConfig extends AbstractConfigSchema
{
    public function getSchema(): Schema
    {
        return Expect::arrayOf(
            Expect::structure([
                'sizeName' => Expect::string()->required(),
                'name' => Expect::string()->required(),
                'width' => Expect::int()->required(),
                'height' => Expect::int()->default(0),
            ])
        );
    }

    public function getConfigFile(): mixed
    {
        try {
            $data = Yaml::parseFile($this->application->configPath() . '/images.yaml');
        } catch (ParseException $e) {
            Helper::warn($e->getMessage());

            return array();
        }

        return $data;
    }

    public function getKey(): string
    {
        return 'images';
    }
}

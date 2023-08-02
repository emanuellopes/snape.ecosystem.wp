<?php

namespace Snape\EcoSystemWP\Config;

use Nette\Schema\Expect;
use Nette\Schema\Schema;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

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

    /**
     * @return array<string, mixed> $config
     */
    public function getConfigFile(): array
    {
        try {
            $data = Yaml::parseFile($this->application->configPath() . '/images.yaml');
        } catch (ParseException $e) {
            error_log('Configuration file not found');

            return array();
        }

        return $data;
    }

    public function getKey(): string
    {
        return 'images';
    }
}

<?php

namespace Snape\EcoSystemWP\Config;

use JsonException;
use Nette\Schema\Expect;
use Nette\Schema\Schema;

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
            $json = json_decode(
                file_get_contents(
                    $this->application->configPath() . '/images.json'
                ),
                true,
                512,
                JSON_THROW_ON_ERROR
            );
        } catch (JsonException $e) {
            error_log('Configuration file not found');

            return array();
        }

        return $json;
    }

    public function getKey(): string
    {
        return 'images';
    }
}

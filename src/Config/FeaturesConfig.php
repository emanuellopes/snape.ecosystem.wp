<?php

namespace Snape\EcoSystemWP\Config;

use JsonException;
use Nette\Schema\Expect;
use Nette\Schema\Schema;

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
            $json = json_decode(
                file_get_contents(
                    $this->application->configPath() . '/features.json'
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
        return 'features';
    }
}

<?php

namespace Snape\EcoSystemWP\Config;

use JsonException;
use Nette\Schema\Expect;
use Nette\Schema\Schema;

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
            $json = json_decode(
                file_get_contents(
                    $this->application->configPath() . '/reset.json'
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
        return 'reset';
    }
}

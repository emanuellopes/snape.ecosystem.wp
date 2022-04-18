<?php

namespace Snape\EcoSystemWP\Config;

use JsonException;
use Nette\Schema\Expect;
use Nette\Schema\Schema;

class ApplicationConfig extends ConfigSchema
{
    public function getSchema(): Schema
    {
        return Expect::structure([
            'providers' => Expect::list('string')->required(),
            'timber' => Expect::structure([
                'views' => Expect::string()->default('views')
            ])->required(),
            'boundedContext' => Expect::string()->required(),
            'theme' => Expect::structure([
                'supports' => Expect::arrayOf(Expect::anyOf(Expect::bool(), Expect::array()), 'string')
            ])->required()
        ]);
    }

    /**
     * @return mixed
     */
    public function getConfigFile()
    {
        try {
            $json = json_decode(
                file_get_contents(
                    $this->application->configPath() . '/app.json'
                ),
                true,
                512,
                JSON_THROW_ON_ERROR
            );
        } catch (JsonException $e) {
            error_log("Configuration file not found");

            return array();
        }

        return $json;
    }

    public function getKey(): string
    {
        return 'app';
    }
}

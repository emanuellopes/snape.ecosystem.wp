<?php

namespace Snape\EcoSystemWP\Bootstrappers;

use Exception;
use Snape\EcoSystemWP\Application\Container;
use Snape\EcoSystemWP\Config\FeaturesConfig;
use Snape\EcoSystemWP\Contracts\IApplicationInterface;
use Snape\EcoSystemWP\Contracts\IBootstrapInterface;
use Snape\EcoSystemWP\Features\AbstractFeature;

/**
 * Register the providers from config files.
 *
 * @package Endor\Application
 */
class RegisterFeatures implements IBootstrapInterface
{
    private IApplicationInterface $application;
    private Container $container;

    private function registerFeaturesConfig(): void
    {
        $featuresConfig = new FeaturesConfig($this->application);

        $config = $this->container->setConfig();
        $config->addSchema(
            $featuresConfig->getKey(),
            $featuresConfig->getSchema()
        );
        $config->merge($featuresConfig->getConfigFile());
    }

    /**
     * Initialize Exception handler tool.
     *
     * @param  IApplicationInterface  $application  Application with container.
     */
    public function bootstrap(IApplicationInterface $application): void
    {
        $this->application = $application;
        $this->container = $application->getContainer();

        $this->registerFeaturesConfig();

        /** @var array $feature_list */
        $feature_list = $this->container->getConfig()->get('features');

        if (empty($feature_list)) {
            return;
        }

        foreach ($feature_list as $feature_type_alias => $features) {
            if ('admin' === $feature_type_alias && ! is_admin()) {
                continue;
            }
            /**
             * @var string $feature_alias
             * @var string $feature
             */
            foreach ($features as $feature_alias => $feature) {
                $abstract_name = sprintf(
                    'snape-ecosystemwp.features.%s.%s',
                    $feature_type_alias,
                    $feature_alias
                );
                if (! is_subclass_of($feature, AbstractFeature::class)) {
                    throw new Exception(
                        sprintf(
                            '%s class is not a child of %s',
                            $feature,
                            AbstractFeature::class
                        )
                    );
                }
                $this->container->addShared($abstract_name, $feature);
                $this->container->get($feature);
            }
        }
    }
}

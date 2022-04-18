<?php

namespace Snape\EcoSystemWP\Providers;

use League\Container\ServiceProvider\BootableServiceProviderInterface;
use Snape\EcoSystemWP\Config\ImagesConfig;
use Snape\EcoSystemWP\Images\RegisterImages;

class ImageServiceProvider extends AbstractBaseServiceProvider implements BootableServiceProviderInterface
{
    private function registerConfig(): void
    {
        $featuresConfig = new ImagesConfig($this->getApplication());

        $config = $this->getConfigurationBuilder();
        $config->addSchema(
            $featuresConfig->getKey(),
            $featuresConfig->getSchema()
        );
        $config->merge($featuresConfig->getConfigFile());
    }

    /**
     * Search for reset files
     */
    public function boot(): void
    {
        $this->registerConfig();

        /** @var array $list_image_size */
        $list_image_size = $this->getConfig()->get('images');

        if (empty($list_image_size)) {
            return;
        }


        $registerImages = new RegisterImages($list_image_size);
        $this->getContainer()->addShared(RegisterImages::class, $registerImages);
    }
}

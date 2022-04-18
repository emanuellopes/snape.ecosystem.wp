<?php

namespace Snape\EcoSystemWP\Providers;

use League\Container\ServiceProvider\BootableServiceProviderInterface;
use Snape\EcoSystemWP\Config\ImagesConfig;
use Snape\EcoSystemWP\Images\RegisterImages;

class ImageServiceProvider extends AbstractBaseServiceProvider implements BootableServiceProviderInterface
{
    /**
     * Search for reset files
     */
    public function boot(): void
    {
        $configSchema = new ImagesConfig($this->getApplication());
        $this->registerConfigSchema($configSchema, $this->getConfigurationBuilder());

        /** @var array $list_image_size */
        $list_image_size = $this->getConfig()->get('images');

        if (empty($list_image_size)) {
            return;
        }


        $registerImages = new RegisterImages($list_image_size);
        $this->getContainer()->addShared(RegisterImages::class, $registerImages);
    }
}

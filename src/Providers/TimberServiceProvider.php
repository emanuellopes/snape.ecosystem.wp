<?php

namespace Snape\EcoSystemWP\Providers;

use League\Container\ServiceProvider\BootableServiceProviderInterface;
use Timber\Timber;


class TimberServiceProvider extends AbstractBaseServiceProvider implements BootableServiceProviderInterface
{
    /**
     * Change some fields in timber after initialize class.
     */
    public function boot(): void
    {
        Timber::init();
        Timber::$dirname = $this->getConfig()->get('app.timber.viewsPath');
        $this->addTemplateAlias();
    }

    /**
     * Register new instance of timber.
     */
    public function register(): void
    {
        $this->getContainer()->addShared(Timber::class);
    }

    public function provides(string $id): bool
    {
        return $id === Timber::class;
    }

    private function addTemplateAlias(): void
    {
        add_filter(
            'timber/loader/loader',
            function ($loader) {
                $viewsPath = $this->getConfig()->get('app.timber.viewsPath');

                /** @var array $alias */
                $alias = $this->getConfig()->get('app.timber.alias');

                /** @var string $folder */
                /** @var string $aliasName */
                foreach ($alias as $folder => $aliasName) {
                    $loader->addPath(
                        sprintf("%s/%s/%s", get_theme_file_path(), $viewsPath, $folder),
                        $aliasName
                    );
                }

                return $loader;
            }
        );
    }
}

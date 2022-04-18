<?php

namespace Snape\EcoSystemWP\Application;

use League\Container\ReflectionContainer;
use Snape\EcoSystemWP\Contracts\IApplicationInterface;
use Snape\EcoSystemWP\Contracts\IBootstrapInterface;

class Application implements IApplicationInterface
{
    use BootstrapTrait;

    private Container $container;

    private string $config;

    private static ?IApplicationInterface $instance = null;

    public static function getInstance(): IApplicationInterface
    {
        if (null === self::$instance) {
            self::$instance = new self('');
        }

        return self::$instance;
    }

    public function __construct(string $basePath)
    {
        self::$instance = $this;
        $this->container = new Container();
        $this->container->delegate(new ReflectionContainer(true));

        $this->config = $basePath . DIRECTORY_SEPARATOR . 'config';
    }

    public function configPath(string $folder_name = 'config'): string
    {
        return $this->config;
    }

    public function getContainer(): Container
    {
        return $this->container;
    }

    public function bootstrap(): void
    {
        if ($this->isBootstrapped()) {
//            throw new ApplicationAlreadyBootstrappedException(static::class . ' already bootstrapped.');
        }
        $this->bootstrapped = true;

        foreach ($this->bootstrappers() as $bootstrapper) {
            // Initialize The Bootstrapers and execute the method bootstrap.
            /** @var IBootstrapInterface $instance */
            $instance = $this->container->getNew($bootstrapper);
            $instance->bootstrap($this);
        }
    }
}

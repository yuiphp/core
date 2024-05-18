<?php

namespace Yui;

use DI\ContainerBuilder;
use Yui\Bootstrap\LoadEnvironmentVariables;
use Yui\Contracts\Application as ApplicationContract;

class Application implements ApplicationContract
{
    /**
     * The Yui framework version.
     *
     * @var string
     */
    public const VERSION = '0.0.1';
    public function version(): string
    {
        return self::VERSION;
    }

    /**
     * The base path of the Laravel installation.
     *
     * @var string
     */
    protected string $basePath;
    public function basePath(): string
    {
        return $this->basePath;
    }

    /**
     * The path to the bootstrap directory.
     *
     * @var string
     */
    protected string $bootstrapPath;
    public function bootstrapPath(): string
    {
        return $this->bootstrapPath;
    }

    /**
     * The path to the application configuration files.
     *
     * @var string
     */
    protected string $configPath;
    public function configPath(): string
    {
        return $this->configPath;
    }

    /**
     * The path to the database directory.
     *
     * @var string
     */
    protected string $databasePath;
    public function databasePath(): string
    {
        return $this->databasePath;
    }


    /**
     * The path to the public directory.
     *
     * @var string
     */
    protected string $publicPath;
    public function publicPath(): string
    {
        return $this->publicPath;
    }

    /**
     * The path to the resources directory.
     *
     * @var string
     */
    protected string $resourcePath;
    public function resourcePath(): string
    {
        return $this->resourcePath;
    }

    /**
     * The path to the storage directory.
     *
     * @var string
     */
    protected string $storagePath;
    public function storagePath(): string
    {
        return $this->storagePath;
    }

    /**
     * The path to the routes directory.
     *
     * @var string
     */
    protected string $routesPath;
    public function routesPath(): string
    {
        return $this->routesPath;
    }

    /**
     * The DI container.
     *
     * @var \DI\Container
     */
    protected \DI\Container $container;

    /**
     * The bootstrap classes for the application.
     *
     * @var array<string>
     */
    protected array $bootstrappers = [
        LoadEnvironmentVariables::class,
    ];

    public function buildContainer(): void
    {
        $containerBuilder = new ContainerBuilder();
        $containerBuilder->addDefinitions(__DIR__ . '/Container/definitions.php');
        $this->container = $containerBuilder->build();
    }

    public static function configure(): self
    {
        return new self();
    }

    public function with(
        string $basePath,
    ): self {
        $this->basePath = $basePath;
        $this->bootstrapPath = $basePath . '/bootstrap';
        $this->databasePath = $basePath . '/app/Database';
        $this->publicPath = $basePath . '/public';
        $this->resourcePath = $basePath . '/resources';
        $this->storagePath = $basePath . '/storage';
        $this->routesPath = $basePath . '/routes';

        return $this;
    }

    public function create(): self
    {
        $this->buildContainer();
        $this->boot();

        return $this;
    }

    protected function boot(): void
    {
        foreach ($this->bootstrappers as $bootstrapper) {
            /** @var \Yui\Contracts\Bootstrap\BootstrapContract $bootstrapper */
            $bootstrapper = new $bootstrapper();
            $bootstrapper->bootstrap($this);
        }
    }
}

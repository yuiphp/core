<?php

namespace Yui;

use DI\ContainerBuilder;
use RuntimeException;
use Yui\Bootstrap\ContainerBootstrap;
use Yui\Bootstrap\LoadEnvironmentVariables;
use DI\Container;
use Yui\Contracts\Bootstrap\BootstrapContract;

/**
 * Class Application
 *
 * @package Yui
 * @author andrefelipe18
 */
class Application
{
    public static ?Application $app = null;
    public Container $container;

    public string $basePath = '';

    private function __construct(){}

    public static function getInstance(): Application
    {
        if(!self::$app) {
            throw new RuntimeException('Application not initialized');
        }

        return self::$app;
    }

    public static function configure(string $basePath): Application
    {
        self::$app = new self();
        self::$app->basePath = $basePath;

        return self::$app;
    }

    public function build(): void
    {
        $this->boot();
    }

    /** * @var BootstrapContract[]  */
    private array $bootstrappers = [
        LoadEnvironmentVariables::class,
        ContainerBootstrap::class
    ];

    private function boot(): void
    {
        foreach ($this->bootstrappers as $bootstrapper) {
            $bootstrapper = new $bootstrapper();
            $bootstrapper->bootstrap($this);
        }
    }
}

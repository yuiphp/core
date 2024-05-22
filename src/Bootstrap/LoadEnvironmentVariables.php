<?php

declare(strict_types=1);

namespace Yui\Bootstrap;

use Dotenv\Dotenv;
use Yui\Contracts\Application;
use Yui\Contracts\Bootstrap\BootstrapContract;

/**
 * Class LoadEnvironmentVariables
 *
 * @author andrefelipe18
 * @package Yui\Bootstrap
 */
class LoadEnvironmentVariables implements BootstrapContract
{
    /**
     * Create a new EnvironmentVariables instance.
     *
     * @param \Yui\Contracts\Application $app
     *
     * @return void
     */
    public function bootstrap(Application $app): void
    {
        $dotenv = Dotenv::createImmutable($app->basePath());
        $dotenv->load();
    }
}

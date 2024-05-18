<?php

declare(strict_types=1);

namespace Yui\Bootstrap;

use Dotenv\Dotenv;
use Yui\Contracts\Application;
use Yui\Contracts\Bootstrap\BootstrapContract;

class LoadEnvironmentVariables implements BootstrapContract
{
    /**
     * Bootstrap the given application.
     *
     * @param \Yui\Contracts\Application  $app
     *
     * @return void
     */
    public function bootstrap(Application $app): void
    {
        $dotenv = Dotenv::createImmutable($app->basePath());
        $dotenv->load();
    }
}

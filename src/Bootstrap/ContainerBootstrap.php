<?php

namespace Yui\Bootstrap;

use Yui\Application;
use Yui\Container\Container;
use Yui\Contracts\Bootstrap\BootstrapContract;

class ContainerBootstrap implements BootstrapContract
{
    public function bootstrap(Application $app): void
    {
        $container = new Container();
        $app->container = $container->build();
    }
}
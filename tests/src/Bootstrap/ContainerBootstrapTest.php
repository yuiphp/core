<?php

use Yui\Application;
use Yui\Bootstrap\ContainerBootstrap;

it('should bootstrap container', function () {
    $app = Mockery::mock(Application::class)->makePartial();

    $containerBootstrap = new ContainerBootstrap();

    $containerBootstrap->bootstrap($app);

    $this->assertInstanceOf(\DI\Container::class, $app->container);

    Mockery::close();
});
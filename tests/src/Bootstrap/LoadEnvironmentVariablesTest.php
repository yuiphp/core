<?php

use Yui\Bootstrap\LoadEnvironmentVariables;
use Yui\Application;

it('should load environment variables', function () {
    $app = Mockery::mock(Application::class)->makePartial();
    $app->allows('basePath')->andReturns(__DIR__);

    $loadEnvironmentVariables = new LoadEnvironmentVariables();

    $loadEnvironmentVariables->bootstrap($app);

    $this->assertArrayHasKey('APP_ENV', $_ENV);
    $this->assertArrayHasKey('APP_DEBUG', $_ENV);

    Mockery::close();
});

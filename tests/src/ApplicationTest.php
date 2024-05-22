<?php

use Yui\Application;

it('configures the application correctly', function () {
    $basePath = '/base/path';
    $bootstrapPath = '/base/path/bootstrap';
    $databasePath = '/base/path/app/Database';
    $publicPath = '/base/path/public';
    $resourcePath = '/base/path/resources';
    $storagePath = '/base/path/storage';
    $routesPath = '/base/path/app/Routes';

    $app = Application::configure()->with(
        $basePath,
        $bootstrapPath,
        $databasePath,
        $publicPath,
        $resourcePath,
        $storagePath,
        $routesPath
    );

    expect($app->basePath())->toBe($basePath)
        ->and($app->bootstrapPath())->toBe($bootstrapPath)
        ->and($app->databasePath())->toBe($databasePath)
        ->and($app->publicPath())->toBe($publicPath)
        ->and($app->resourcePath())->toBe($resourcePath)
        ->and($app->storagePath())->toBe($storagePath)
        ->and($app->routesPath())->toBe($routesPath);
});
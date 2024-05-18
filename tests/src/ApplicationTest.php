<?php

use Yui\Application;
use Yui\Bootstrap\LoadEnvironmentVariables;

it('configures the application correctly', function () {
	$basePath = '/base/path';
	$bootstrapPath = '/base/path/bootstrap';
	$databasePath = '/base/path/database';
	$publicPath = '/base/path/public';
	$resourcePath = '/base/path/resources';
	$storagePath = '/base/path/storage';
	$routesPath = '/base/path/routes';

	$app = Application::configure()->with(
		$basePath,
		$bootstrapPath,
		$databasePath,
		$publicPath,
		$resourcePath,
		$storagePath,
		$routesPath
	);

	expect($app->basePath())->toBe($basePath);
	expect($app->bootstrapPath())->toBe($bootstrapPath);
	expect($app->databasePath())->toBe($databasePath);
	expect($app->publicPath())->toBe($publicPath);
	expect($app->resourcePath())->toBe($resourcePath);
	expect($app->storagePath())->toBe($storagePath);
	expect($app->routesPath())->toBe($routesPath);
});
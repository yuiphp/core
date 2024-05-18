<?php

declare(strict_types=1);

namespace Yui\Bootstrap;

use Dotenv\Dotenv;
use Yui\Contracts\Application;

class LoadEnvironmentVariables
{
	/**
	 * Bootstrap the given application.
	 * 
	 * @param \Yui\Contracts\Application  $app
	 * 
	 * @return void
	 */
	public function bootstrap(Application $app)
	{
		$dotenv = Dotenv::createImmutable($app->basePath());
		$dotenv->load();
	}
}
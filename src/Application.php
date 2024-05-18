<?php

namespace Yui;

use Yui\Bootstrap\LoadEnvironmentVariables;
use Yui\Contracts\Application as ApplicationContract;

class Application implements ApplicationContract
{
	/**
	 * The Yui framework version.
	 *
	 * @var string
	 */
	const VERSION = '0.0.1';
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
	 * The bootstrap classes for the application.
	 * 
	 * @var string[]
	 */
	protected array $bootstrappers = [
		LoadEnvironmentVariables::class,
	];

	public static function configure(): self
	{
		return new static();
	}

	public function with(
		?string $basePath = null,
		?string $bootstrapPath = null,
		?string $databasePath = null,
		?string $publicPath = null,
		?string $resourcePath = null,
		?string $storagePath = null,
		?string $routesPath = null
	): self {
		$this->basePath = $basePath;
		$this->bootstrapPath = $bootstrapPath;
		$this->databasePath = $databasePath;
		$this->publicPath = $publicPath;
		$this->resourcePath = $resourcePath;
		$this->storagePath = $storagePath;
		$this->routesPath = $routesPath;

		return $this;
	}

	public function create(): self
	{
		$this->boot();

		return $this;
	}

	public function boot(): void
	{
		foreach ($this->bootstrappers as $bootstrapper) {
			(new $bootstrapper)->bootstrap($this);
		}
	}
}
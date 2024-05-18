<?php

declare(strict_types=1);

namespace Yui\Contracts;

interface Application
{
    /**
     * Get the version number of the application.
     *
     * @return string
     */
    public function version(): string;

    /**
     * Get the base path of the application.
     *
     * @return string
     */
    public function basePath(): string;

    /**
     * Get the path to the bootstrap directory.
     *
     * @return string
     */
    public function bootstrapPath(): string;

    /**
     * Get the path to the application configuration files.
     *
     * @return string
     */
    public function configPath(): string;

    /**
     * Get the path to the database directory.
     *
     * @return string
     */
    public function databasePath(): string;

    /**
     * Get the path to the public directory.
     *
     * @return string
     */
    public function publicPath(): string;

    /**
     * Get the path to the resources directory.
     *
     * @return string
     */
    public function resourcePath(): string;

    /**
     * Get the path to the storage directory.
     *
     * @return string
     */
    public function storagePath(): string;

    /**
     * Get the path to the routes directory.
     *
     * @return string
     */
    public function routesPath(): string;

    /**
     * Build the application container.
     *
     * @return void
     */
    public function buildContainer(): void;

    /**
     * Configure the application to be bootstrapped.
     *
     * @return self
     */
    public static function configure(): self;

    /**
     * Set the paths for the application.
     *
     * @param string|null $basePath
     * @param string|null $bootstrapPath
     * @param string|null $databasePath
     * @param string|null $publicPath
     * @param string|null $resourcePath
     * @param string|null $storagePath
     * @param string|null $routesPath
     *
     * @return self
     */
    public function with(
        ?string $basePath = null,
        ?string $bootstrapPath = null,
        ?string $databasePath = null,
        ?string $publicPath = null,
        ?string $resourcePath = null,
        ?string $storagePath = null,
        ?string $routesPath = null,
    ): self;

    /**
     * Create the application.
     *
     * @return self
     */
    public function create(): self;
}
<?php

declare(strict_types=1);

namespace Yui\Database\Connection\Drivers;

use Exception;
use PDO;
use Yui\Contracts\Database\Driver\DriverContract;

/**
 * Class AbstractDatabaseDriver
 *
 * @author andrefelipe18
 * @package Yui\Database\Connection\Drivers
 */
abstract class AbstractDatabaseDriver implements DriverContract
{
    /**
     * Create a new PDO instance.
     *
     * @param string $dsn
     * @param string|null $username
     * @param string|null $password
     * @return PDO
     * @throws Exception
     */
    protected function createPDO(string $dsn, ?string $username = null, ?string $password = null): PDO
    {
        try {
            $pdo = new PDO($dsn, $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

            return $pdo;
        } catch (Exception $e) {
            throw new Exception("Error connecting to database: {$e->getMessage()}");
        }
    }

    /**
     * Get the environment variable.
     *
     * @param string $key
     * @return string
     * @throws Exception
     */
    protected function getEnv(string $key): string
    {
        $value = $_ENV[$key] ?? null;

        if ($value === null) {
            throw new Exception("{$key} environment variable is not set");
        }

        return $value;
    }
}

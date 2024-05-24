<?php

declare(strict_types=1);

namespace Yui\Database\Connection;

use Exception;
use PDO;
use Yui\Contracts\Database\Driver\DriverContract;
use Yui\Database\Connection\Drivers\MysqlDriver;
use Yui\Database\Connection\Drivers\PgsqlDriver;
use Yui\Database\Connection\Drivers\SqliteDriver;

/**
 * Class Connection
 *
 * @author andrefelipe18
 * @package Yui\Database\DatabaseConnection
 */
class DatabaseConnection
{
    /**
     * @var DriverContract
     */
    protected $driver;

    /**
     * Connect to the database and return the PDO instance.
     *
     * @return PDO
     */
    public function connect(): PDO
    {
        return $this->getDriver()->connect();
    }

    /**
     * Get the driver instance.
     *
     * @return DriverContract
     */
    protected function getDriver(): DriverContract
    {
        if ($this->driver) {
            return $this->driver;
        }

        $driver = $_ENV['DB_CONNECTION'];

        switch ($driver) {
            case 'mysql':
                return new MysqlDriver();
            case 'pgsql':
                return new PgsqlDriver();
            case 'sqlite':
                return new SqliteDriver();
            default:
                throw new Exception('Invalid database driver');
        }
    }

    /**
     * Set driver instance if needed.
     *
     * @param DriverContract $driver
     */
    public function setDriver(DriverContract $driver): void
    {
        $this->driver = $driver;
    }
}

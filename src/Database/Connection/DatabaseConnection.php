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
    public function __construct(protected DriverContract $driver)
    {
        $this->validateDriver($driver);
    }

    /**
     * Connect to the database and return the PDO instance.
     *
     * @return PDO
     */
    public function connect(): PDO
    {
        return $this->driver->connect();
    }

    /**
     * @throws Exception
     */
    private function validateDriver(DriverContract $driver): void
    {
        if (!($driver instanceof MysqlDriver) && !($driver instanceof PgsqlDriver) && !($driver instanceof SqliteDriver)) {
            throw new Exception('Invalid database driver');
        }
    }
}

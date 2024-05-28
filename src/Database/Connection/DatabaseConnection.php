<?php

declare(strict_types=1);

namespace Yui\Database\Connection;

use Exception;
use PDO;
use Yui\Application;
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
    private static ?PDO $connection = null;
    private static DriverContract $driver;

    private function __construct(){}

    /**
     * Connect to the database and return the PDO instance.
     *
     * @return PDO
     */
    public static function connect(): PDO
    {
        self::validateDriver();

        if (self::$connection === null) {
           self::$connection = self::$driver->connect();
        }

        return self::$connection;
    }

    /**
     * @throws Exception
     */
    private static function validateDriver(): void
    {
        self::$driver = Application::getInstance()->container->get(DriverContract::class);
        if (!(self::$driver instanceof MysqlDriver) && !(self::$driver instanceof PgsqlDriver) && !(self::$driver instanceof SqliteDriver)) {
            throw new Exception('Invalid database driver');
        }
    }
}

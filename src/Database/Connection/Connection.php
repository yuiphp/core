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
 * @package Yui\Database\Connection
 */
class Connection
{
    /**
     * @var PDO|null
     */
    private static ?PDO $pdo = null;

    /**
     * Connect to the database and return the PDO instance.
     *
     * @return PDO
     */
    public static function connect(): PDO
    {

        if (self::$pdo !== null) {
            return self::$pdo;
        }

        self::$pdo = self::getDriver()->connect();

        return self::$pdo;
    }

    /**
     * Close the connection to the database.
     *
     * @return void
     */
    public function close(): void
    {
        self::$pdo = null;
    }

    /**
     * Get the driver instance.
     *
     * @return DriverContract
     */
    protected static function getDriver(): DriverContract
    {
        $driver = $_ENV['DB_CONNECTION'];

        switch ($driver) {
            case 'mysql':
                return new MysqlDriver;
            case 'pgsql':
                return new PgsqlDriver;
            case 'sqlite':
                return new SqliteDriver;
            default:
                throw new Exception('Invalid database driver');
        }
    }
}

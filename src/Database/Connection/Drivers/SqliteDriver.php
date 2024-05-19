<?php

declare(strict_types=1);

namespace Yui\Database\Connection\Drivers;

use PDO;
use Exception;
use Yui\Contracts\Database\Driver\DriverContract;

/**
 * Class SqliteDriver
 *
 * @author andrefelipe18
 * @package Yui\Database\Connection\Drivers
 */
class SqliteDriver extends AbstractDatabaseDriver implements DriverContract
{
    /**
     * Connect to the SQLite database.
     *
     * @return PDO
     * @throws Exception
     */
    public function connect(): PDO
    {
        $pathToSqlite = $this->getEnv('DB_DATABASE');
        $pathToSqlite = realpath($pathToSqlite);

        if ($pathToSqlite === false) {
            throw new Exception('Invalid path to SQLite database');
        }

        $dsn = 'sqlite:' . $pathToSqlite;

        return $this->createPDO($dsn);
    }
}

<?php

declare(strict_types=1);

namespace Yui\Database\Connection\Drivers;

use PDO;
use Exception;

class SqliteDriver extends DatabaseDriver
{
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

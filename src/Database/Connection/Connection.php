<?php

declare(strict_types=1);

namespace Yui\Database\Connection;

use PDO;
use Yui\Contracts\Database\Driver\DriverContract;

class Connection
{
    /**
     * @var PDO|null
     */
    private static ?PDO $pdo = null;

    public function __construct(
        private DriverContract $driver
    ) {
    }

    public function connect(): PDO
    {
        if (self::$pdo !== null) {
            return self::$pdo;
        }

        self::$pdo = $this->driver->connect();
 
        return self::$pdo;
    }
}

<?php

declare(strict_types=1);

namespace Yui\Database\Connection\Drivers;

use PDO;

class MysqlDriver extends AbstractDatabaseDriver
{
    public function connect(): PDO
    {
        $host = $this->getEnv('DB_HOST');
        $port = $this->getEnv('DB_PORT');
        $database = $this->getEnv('DB_DATABASE');
        $username = $this->getEnv('DB_USERNAME');
        $password = $this->getEnv('DB_PASSWORD');

        $dsn = "mysql:host={$host};port={$port};dbname={$database}";

        return $this->createPDO($dsn, $username, $password);
    }
}

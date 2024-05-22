<?php

declare(strict_types=1);

namespace Yui\Contracts\Database;

use PDOStatement;

interface DBContract
{
    /**
     * Run a SQL query using the PDO connection
     *
     * @param string $sql
     * @return int Number of affected rows
     */
    public function runQuery(string $sql): int;

    /**
     * Get a SQL query using the PDO connection
     *
     * @param string $sql
     * @return PDOStatement
     */
    public function getQuery(string $sql): PDOStatement;
}
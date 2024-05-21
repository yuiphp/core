<?php

declare(strict_types=1);

namespace Yui\Database;

use Exception;
use PDO;
use PDOException;
use PDOStatement;
use Yui\Contracts\Database\DBContract;
use Yui\Database\Connection\DatabaseConnection;

class DB implements DBContract
{
    /**
     * Database handler
     * 
     * @var PDO|null
     */
    private ?PDO $dbh = null;

    public function __construct(DatabaseConnection $dbConn)
    {
        try
        {
            $this->dbh = $dbConn->connect(); // Connecting to the database
        }
        catch(PDOException $e)
        {
            throw new Exception("Error connecting to the database: " . $e->getMessage(), 0, $e);
        }
    }

    public function __destruct()
    {
        $this->dbh = NULL; // Setting the handler to NULL closes the connection properly
    }

    /**
     * Run a SQL query using the PDO connection
     * 
     * @param string $sql
     * @return int Number of affected rows
     * @throws Exception If there is an error running the query
     */
    public function runQuery(string $sql): int
    {
        try
        {
            return $this->dbh->exec($sql);
        }
        catch(PDOException $e)
        {
            throw new Exception("Error running query: " . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Get a SQL query using the PDO connection
     * 
     * @param string $sql
     * @return PDOStatement
     * @throws Exception If there is an error running the query
     */
    public function getQuery(string $sql): PDOStatement
    {
        try
        {
            $stmt = $this->dbh->query($sql);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            return $stmt;
        }
        catch(PDOException $e)
        {
            throw new Exception("Error running query: " . $e->getMessage(), 0, $e);
        }
    }
}
<?php

declare(strict_types=1);

namespace Yui\Database;

use Exception;
use PDO;
use PDOException;
use PDOStatement;
use Yui\Contracts\Database\DBContract;
use Yui\Database\Connection\DatabaseConnection;
use RuntimeException;

class DB implements DBContract
{
    /**
     * Database handler
     *
     * @var PDO|null
     */
    private ?PDO $dbh = null;

    /**
     * @param DatabaseConnection $dbConn
     *
     * @throws Exception
     */
    public function __construct(DatabaseConnection $dbConn)
    {
        try {
            $this->dbh = $dbConn->connect(); // Connecting to the database
        } catch (PDOException $e) {
            throw new RuntimeException("Error connecting to the database: " . $e->getMessage(), 0, $e);
        }
    }

    public function __destruct()
    {
        $this->dbh = null; // Setting the handler to NULL closes the connection properly
    }

    /**
     * Get the PDO connection
     */
    public function getDbh(): PDO
    {
        return $this->dbh;
    }

    /**
     * Run a SQL query using the PDO connection
     *
     * @param string $sql
     * @return int Number of affected rows
     * @throws Exception If there is an error running the query
     */
    public function runQuery(string $sql, array $params = []): int
    {
        try {
            $stmt = $this->dbh->prepare($sql);
            if (!$stmt) {
                throw new RuntimeException("Error preparing query: " . $this->dbh->errorInfo()[2]);
            }
            foreach ($params as $param => $value) {
                $stmt->bindValue(':'.$param, $value);
            }
            $stmt->execute();
            return $stmt->rowCount();
        } catch (PDOException $e) {
            throw new RuntimeException("Error running query: " . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Get a PDOStatement object for a query
     *
     * @param string $sql
     * @return PDOStatement
     * @throws Exception If there is an error running the query
     */
    public function getQuery(string $sql, array $params = []): PDOStatement
    {
        try {
            $stmt = $this->dbh->prepare($sql);
            if (!$stmt) {
                throw new RuntimeException("Error preparing query: " . $this->dbh->errorInfo()[2]);
            }
            foreach ($params as $param => $value) {
                $stmt->bindValue(':'.$param, $value);
            }
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new RuntimeException("Error running query: " . $e->getMessage(), 0, $e);
        }
    }
}

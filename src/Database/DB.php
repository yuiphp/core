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
     * @param DatabaseConnection $databaseConnection
     *
     * @throws Exception
     */
    public function __construct(DatabaseConnection $databaseConnection)
    {
        try {
            $this->dbh = $databaseConnection->connect(); // Connecting to the database
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
     * @param array $params
     * @return int Number of affected rows
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
     * @param array $params
     * @return PDOStatement
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

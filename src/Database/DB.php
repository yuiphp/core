<?php

declare(strict_types=1);

namespace Yui\Database;

use Exception;
use PDO;
use PDOException;
use PDOStatement;
use Yui\Contracts\Database\DBContract;
use Yui\Database\Connection\DatabaseConnection;
use Yui\Exceptions\DatabaseException;

class DB implements DBContract
{
    private ?PDO $pdoConnection = null;

    public function __construct(DatabaseConnection $databaseConnection)
    {
        try {
            $this->pdoConnection = $databaseConnection->connect();
        } catch (PDOException $e) {
            throw new DatabaseException("Error connecting to the database: " . $e->getMessage(), 0, $e);
        }
    }

    public function __destruct()
    {
        $this->pdoConnection = null;
    }

    public function getPdoConnection(): PDO
    {
        return $this->pdoConnection;
    }

    public function runQuery(string $sql, array $params = []): int
    {
        return $this->prepareAndExecute($sql, $params)->rowCount();
    }

    public function getQuery(string $sql, array $params = []): PDOStatement
    {
        return $this->prepareAndExecute($sql, $params);
    }

    /**
     * @throws DatabaseException
     */
    private function prepareAndExecute(string $sql, array $params = []): PDOStatement
    {
        try {
            $stmt = $this->pdoConnection->prepare($sql);
            if (!$stmt) {
                throw new DatabaseException("Error preparing query: " . $this->pdoConnection->errorInfo()[2]);
            }
            foreach ($params as $param => $value) {
                $stmt->bindValue(':'.$param, $value);
            }
            $stmt->setFetchMode(PDO::FETCH_OBJ);
            $stmt->execute();
            return $stmt;
        } catch (PDOException $e) {
            throw new DatabaseException("Error running query: " . $e->getMessage(), 0, $e);
        }
    }
}
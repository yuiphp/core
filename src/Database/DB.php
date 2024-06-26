<?php

declare(strict_types=1);

namespace Yui\Database;

use PDO;
use PDOException;
use PDOStatement;
use Yui\Contracts\Database\DBContract;
use Yui\Database\Connection\DatabaseConnection;
use Yui\Exceptions\DatabaseException;

class DB implements DBContract
{
    private ?PDO $pdoConnection = null;

    public function __construct(DatabaseConnection $pdoConnection)
    {
        $this->pdoConnection = $pdoConnection::connect();
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

/**
 * Essa classe eu quero pegar ela vindo do container
 *
 * ou seja $db = $container->get(DB::class);
 */
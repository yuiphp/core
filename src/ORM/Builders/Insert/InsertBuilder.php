<?php

declare(strict_types=1);

namespace Yui\ORM\Builders\Insert;

use Exception;
use RuntimeException;
use Yui\Database\DB;
use Yui\ORM\Clauses\InsertClause;

class InsertBuilder
{
    /** @var array<InsertClause> */
    private array $clauses = [
        'insert' => null,
    ];

    private DB $db;

    public function __construct(string $table, DB $db)
    {
        $this->db = $db;
        $this->clauses['insert'] = new InsertClause();
        $this->clauses['insert']->set(['table' => $table]);
    }

    public function values(array $values): void
    {
        $this->clauses['insert']->values($values);
        $this->execute();
    }

    public function valuesGetId(array $values): int
    {
        $this->clauses['insert']->values($values);
        return $this->execute();
    }

    private function execute(): int
    {
        $query = $this->clauses['insert']->getSql();
        $bindings = $this->clauses['insert']->getBindings();

        try {
            $stmt = $this->db->getDbh();
            $stmt->beginTransaction();
            $stmt->prepare($query);
            $stmt->execute($bindings);
            $id = (int)$stmt->lastInsertId();
            $stmt->commit();
            return $id;
        } catch (Exception $e) {
            if ($stmt !== null) {
                $stmt->rollBack();
            }
            throw new RuntimeException($e->getMessage());
        }
    }
}

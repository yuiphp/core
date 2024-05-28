<?php

declare(strict_types=1);

namespace Yui\ORM;

use Yui\Database\DB;
use Yui\ORM\Builders\Delete\DeleteBuilder;
use Yui\ORM\Builders\Insert\InsertBuilder;
use Yui\ORM\Builders\Select\SelectBuilder;
use Yui\ORM\Builders\Update\UpdateBuilder;
use Yui\ORM\Builders\Upsert\UpsertBuilder;

class QueryBuilder
{
    private DB $db;

    public function __construct(DB $db)
    {
        $this->db = $db;
    }
    public function select(string ...$columns): SelectBuilder
    {
        return new SelectBuilder(...$columns);
    }

    public function insert(string $table): InsertBuilder
    {
        return new InsertBuilder($table, $this->db);
    }

    public function update(string $table): UpdateBuilder
    {
        return new UpdateBuilder($table, $this->db);
    }

    public function delete(string $table): DeleteBuilder
    {
        return new DeleteBuilder($table, $this->db);
    }

    public function upsert(string $table): UpsertBuilder
    {
        return new UpsertBuilder($table, $this->db);
    }
}

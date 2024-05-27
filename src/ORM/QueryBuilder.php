<?php

declare(strict_types=1);

namespace Yui\ORM;

use Yui\Application;
use Yui\Database\DB;
use Yui\ORM\Builders\Delete\DeleteBuilder;
use Yui\ORM\Builders\Insert\InsertBuilder;
use Yui\ORM\Builders\Select\SelectBuilder;
use Yui\ORM\Builders\Update\UpdateBuilder;

class QueryBuilder
{
    public function select(string ...$columns): SelectBuilder
    {
        return new SelectBuilder(...$columns);
    }

    public function insert(string $table): InsertBuilder
    {
        $db = Application::getInstance()->container->get(DB::class);
        return new InsertBuilder($table, $db);
    }

    public function update(): UpdateBuilder
    {
        $db = Application::getInstance()->container->get(DB::class);
        return new UpdateBuilder('1', $db);
    }

    public function delete(): DeleteBuilder
    {
        $db = Application::getInstance()->container->get(DB::class);
        return new DeleteBuilder('1', $db);
    }

    public function upsert(): UpsertBuilder
    {
        $db = Application::getInstance()->container->get(DB::class);
        return new UpsertBuilder('1', $db);
    }
}

<?php

declare(strict_types=1);

namespace Yui\ORM;

use Yui\ORM\Builders\Delete\DeleteBuilder;
use Yui\ORM\Builders\Insert\InsertBuilder;
use Yui\ORM\Builders\Select\SelectBuilder;
use Yui\ORM\Builders\Update\UpdateBuilder;

class QueryBuilder
{
    protected $builder;

    public function select(string ...$columns): SelectBuilder
    {
        $this->builder = new SelectBuilder(...$columns);
        return $this->builder;
    }

    public function insert()
    {
        $this->builder = new InsertBuilder('1');
        return $this->builder;
    }

    public function update()
    {
        $this->builder = new UpdateBuilder('1');
        return $this->builder;
    }

    public function delete()
    {
        $this->builder = new DeleteBuilder('1');
        return $this->builder;
    }
}

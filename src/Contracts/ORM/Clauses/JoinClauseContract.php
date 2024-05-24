<?php

declare(strict_types=1);

namespace Yui\Contracts\ORM\Clauses;

interface JoinClauseContract extends ClauseContract
{
    public function leftJoin(string $table, string|callable $sql): void;
    public function rightJoin(string $table, string|callable $sql): void;
    public function innerJoin(string $table, string|callable $sql): void;
    public function fullJoin(string $table, string|callable $sql): void;
}

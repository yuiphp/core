<?php

declare(strict_types=1);

namespace Yui\ORM\Clauses;

use Yui\Contracts\ORM\Clauses\JoinClauseContract;

class JoinClause implements JoinClauseContract
{
    private const LEFT_JOIN = ' LEFT JOIN ';
    private const RIGHT_JOIN = ' RIGHT JOIN ';
    private const INNER_JOIN = ' INNER JOIN ';
    private const FULL_JOIN = ' FULL JOIN ';
    private const ON = ' ON ';

    protected array $joins = [];
    protected array $bindings = [];

    public function set(array $data): void
    {
    }

    public function leftJoin(string $table, string|callable $sql): void
    {
        $this->joins[] = self::LEFT_JOIN . ':JoinTable' . self::ON . ':sql';
        $this->bindings['JoinTable'] = $table;
        $this->bindings['sql'] = is_callable($sql) ? $sql() : $sql;
    }

    public function rightJoin(string $table, string|callable $sql): void
    {
        $this->joins[] = self::RIGHT_JOIN . ':JoinTable' . self::ON . ':sql';
        $this->bindings['JoinTable'] = $table;
        $this->bindings['sql'] = is_callable($sql) ? $sql() : $sql;
    }

    public function innerJoin(string $table, string|callable $sql): void
    {
        $this->joins[] = self::INNER_JOIN . ':JoinTable' . self::ON . ':sql';
        $this->bindings['JoinTable'] = $table;
        $this->bindings['sql'] = is_callable($sql) ? $sql() : $sql;
    }

    public function fullJoin(string $table, string|callable $sql): void
    {
        $this->joins[] = self::FULL_JOIN . ':JoinTable' . self::ON . ':sql';
        $this->bindings['JoinTable'] = $table;
        $this->bindings['sql'] = is_callable($sql) ? $sql() : $sql;
    }

    public function getSql(): string
    {
        return trim(implode(' ', $this->joins));
    }

    public function getBindings(): array
    {
        return $this->bindings;
    }
}

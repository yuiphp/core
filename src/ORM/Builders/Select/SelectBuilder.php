<?php

declare(strict_types=1);

namespace Yui\ORM\Builders\Select;

use DI\DependencyException;
use DI\NotFoundException;
use Exception;
use RuntimeException;
use Yui\Application;
use Yui\Contracts\ORM\Clauses\ClauseContract;
use Yui\Contracts\ORM\Clauses\GroupByClauseContract;
use Yui\Contracts\ORM\Clauses\JoinClauseContract;
use Yui\Contracts\ORM\Clauses\SelectClauseContract;
use Yui\Contracts\ORM\Clauses\WhereClauseContract;
use Yui\Database\DB;
use Yui\ORM\Clauses\FromClause;
use Yui\ORM\Clauses\GroupByClause;
use Yui\ORM\Clauses\JoinClause;
use Yui\ORM\Clauses\LimitClause;
use Yui\ORM\Clauses\OffsetClause;
use Yui\ORM\Clauses\OrderByClause;
use Yui\ORM\Clauses\SelectClause;
use Yui\ORM\Clauses\WhereClause;

class SelectBuilder
{
    /** @var array<ClauseContract|WhereClauseContract|JoinClauseContract|SelectClauseContract|GroupByClauseContract> */
    private array $clauses = [
        'from' => null,
        'groupBy' => null,
        'join' => null,
        'limit' => null,
        'offset' => null,
        'orderBy' => null,
        'select' => null,
        'where' => null,
    ];

    public function __construct(string ...$columns)
    {
        $this->clauses['from'] = new FromClause();
        $this->clauses['groupBy'] = new GroupByClause();
        $this->clauses['join'] = new JoinClause();
        $this->clauses['limit'] = new LimitClause();
        $this->clauses['offset'] = new OffsetClause();
        $this->clauses['orderBy'] = new OrderByClause();
        $this->clauses['select'] = new SelectClause();
        $this->clauses['where'] = new WhereClause();

        $this->clauses['select']->set(['columns' => $columns]);
    }

    public function from(string $table, ?string $alias = null): self
    {
        $this->clauses['from']->set(['table' => $table, 'alias' => $alias]);
        return $this;
    }

    public function where(string|callable $filter): self
    {
        $sql = is_callable($filter) ? $filter() : $filter;
        $this->clauses['where']->set(['sql' => $sql]);
        return $this;
    }

    public function andWhere(string|callable $filter): self
    {
        $sql = is_callable($filter) ? $filter() : $filter;
        $this->clauses['where']->and($sql);
        return $this;
    }

    public function orWhere(string|callable $filter): self
    {
        $sql = is_callable($filter) ? $filter() : $filter;
        $this->clauses['where']->or($sql);
        return $this;
    }

    public function distinct(): self
    {
        $this->clauses['select']->distinct();
        return $this;
    }

    public function distinctOn(string ...$columns): self
    {
        $this->clauses['select']->distinctOn(...$columns);
        return $this;
    }

    public function limit(int $limit): self
    {
        $this->clauses['limit']->set(['limit' => $limit]);
        return $this;
    }

    public function offset(int $offset): self
    {
        $this->clauses['offset']->set(['offset' => $offset]);
        return $this;
    }

    public function orderBy(string $column, string $direction = 'ASC'): self
    {
        $this->clauses['orderBy']->set(['orderByColumn' => $column, 'direction' => $direction]);
        return $this;
    }

    public function groupBy(string ...$columns): self
    {
        $this->clauses['groupBy']->set(['groupByColumns' => $columns]);
        return $this;
    }

    public function having(string $sql): self
    {
        $sql = is_callable($sql) ? $sql() : $sql;
        $this->clauses['groupBy']->having($sql);
        return $this;
    }

    public function columnAs(string $column, string $alias): self
    {
        $this->clauses['select']->alias($column, $alias);
        return $this;
    }

    public function leftJoin(string $table, string|callable $sql): self
    {
        $sql = is_callable($sql) ? $sql() : $sql;
        $this->clauses['join']->leftJoin($table, $sql);
        return $this;
    }

    public function rightJoin(string $table, string|callable $sql): self
    {
        $sql = is_callable($sql) ? $sql() : $sql;
        $this->clauses['join']->rightJoin($table, $sql);
        return $this;
    }

    public function innerJoin(string $table, string|callable $sql): self
    {
        $sql = is_callable($sql) ? $sql() : $sql;
        $this->clauses['join']->innerJoin($table, $sql);
        return $this;
    }

    public function fullJoin(string $table, string|callable $sql): self
    {
        $sql = is_callable($sql) ? $sql() : $sql;
        $this->clauses['join']->fullJoin($table, $sql);
        return $this;
    }

    /**
     * @throws DependencyException
     * @throws NotFoundException
     * @throws RuntimeException
     * @throws Exception
     */
    public function get(): array
    {
        $db = Application::getInstance()->container->get(DB::class);

        return $db->getQuery($this->getQueryString(), $this->getBindings())->fetchAll();
    }

    public function getQueryString(): string
    {
        $sqlParts = [
            $this->clauses['select']->getSql(),
            $this->clauses['from']->getSql(),
            $this->clauses['join']->getSql(),
            $this->clauses['where']->getSql(),
            $this->clauses['groupBy']->getSql(),
            $this->clauses['orderBy']->getSql(),
            $this->clauses['limit']->getSql(),
            $this->clauses['offset']->getSql(),
        ];

        // Remove empty parts
        $sqlParts = array_filter($sqlParts, function ($part) {
            return !empty(trim($part));
        });

        return implode(' ', $sqlParts);
    }

    public function getSqlWithBindings(): string
    {
        $sql = $this->getQueryString();
        $bindings = $this->getBindings();

        foreach ($bindings as $key => $value) {
            $sql = str_replace(':' . $key, (string)$value, $sql);
        }

        return $sql;
    }

    protected function getBindings(): array
    {
        $bindings = [];

        foreach ($this->clauses as $clause) {
            $bindings[] = $clause->getBindings();
        }

        return array_merge(...$bindings);
    }
}

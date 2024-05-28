<?php

declare(strict_types=1);

namespace Yui\ORM\Builders\Select;

use DI\DependencyException;
use DI\NotFoundException;
use Exception;
use RuntimeException;
use Yui\Application;
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
    protected FromClause $from;
    protected GroupByClause $groupBy;

    protected JoinClause $join;
    protected LimitClause $limit;
    protected OffsetClause $offset;
    protected OrderByClause $orderBy;
    protected SelectClause $select;
    protected WhereClause $where;


    public function __construct(string ...$columns)
    {
        $this->from = new FromClause();
        $this->groupBy = new GroupByClause();
        $this->join = new JoinClause();
        $this->limit = new LimitClause();
        $this->offset = new OffsetClause();
        $this->orderBy = new OrderByClause();
        $this->select = new SelectClause();
        $this->where = new WhereClause();

        $this->select->set(['columns' => $columns]);
    }

    public function from(string $table, ?string $alias = null): self
    {
        $this->from->set(['table' => $table, 'alias' => $alias]);
        return $this;
    }

    public function where(string|callable $filter): self
    {
        $sql = is_callable($filter) ? $filter() : $filter;
        $this->where->set(['sql' => $sql]);
        return $this;
    }

    public function andWhere(string|callable $filter): self
    {
        $sql = is_callable($filter) ? $filter() : $filter;
        $this->where->and($sql);
        return $this;
    }

    public function orWhere(string|callable $filter): self
    {
        $sql = is_callable($filter) ? $filter() : $filter;
        $this->where->or($sql);
        return $this;
    }

    public function distinct(): self
    {
        $this->select->distinct();
        return $this;
    }

    public function distinctOn(string ...$columns): self
    {
        $this->select->distinctOn(...$columns);
        return $this;
    }

    public function limit(int $limit): self
    {
        $this->limit->set(['limit' => $limit]);
        return $this;
    }

    public function offset(int $offset): self
    {
        $this->offset->set(['offset' => $offset]);
        return $this;
    }

    public function orderBy(string $column, string $direction = 'ASC'): self
    {
        $this->orderBy->set(['orderByColumn' => $column, 'direction' => $direction]);
        return $this;
    }

    public function groupBy(string ...$columns): self
    {
        $this->groupBy->set(['groupByColumns' => $columns]);
        return $this;
    }

    public function having(string $sql): self
    {
        $sql = is_callable($sql) ? $sql() : $sql;
        $this->groupBy->having($sql);
        return $this;
    }

    public function columnAs(string $column, string $alias): self
    {
        $this->select->alias($column, $alias);
        return $this;
    }

    public function leftJoin(string $table, string|callable $sql): self
    {
        $sql = is_callable($sql) ? $sql() : $sql;
        $this->join->leftJoin($table, $sql);
        return $this;
    }

    public function rightJoin(string $table, string|callable $sql): self
    {
        $sql = is_callable($sql) ? $sql() : $sql;
        $this->join->rightJoin($table, $sql);
        return $this;
    }

    public function innerJoin(string $table, string|callable $sql): self
    {
        $sql = is_callable($sql) ? $sql() : $sql;
        $this->join->innerJoin($table, $sql);
        return $this;
    }

    public function fullJoin(string $table, string|callable $sql): self
    {
        $sql = is_callable($sql) ? $sql() : $sql;
        $this->join->fullJoin($table, $sql);
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
            $this->select->getSql(),
            $this->from->getSql(),
            $this->join->getSql(),
            $this->where->getSql(),
            $this->groupBy->getSql(),
            $this->orderBy->getSql(),
            $this->limit->getSql(),
            $this->offset->getSql(),
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
        $bindings = array_map(function ($clause) {
            return $clause->getBindings();
        }, [$this->select, $this->from, $this->join, $this->where, $this->groupBy, $this->orderBy, $this->limit, $this->offset]);

        return array_merge(...$bindings);
    }
}

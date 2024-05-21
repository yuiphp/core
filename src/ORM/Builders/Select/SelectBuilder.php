<?php

declare(strict_types=1);

namespace Yui\ORM\Builders\Select;

class SelectBuilder
{
    /** @var array<string> */
    protected array $columns = [];
    protected ?string $table = null;
    protected ?string $distinct = null;
    protected ?string $where = null;
    protected ?int $limit = null;
    protected ?int $offset = null;
    protected ?string $orderBy = null;

    public function __construct(string ...$columns)
    {
        $this->columns = $columns ?: ['*'];
        $this->columns = array_unique($this->columns);

        return $this;
    }

    public function from(string $table): self
    {
        $this->table = $table;
        return $this;
    }

    public function where(string|callable $sql): self
    {
        $this->where = is_callable($sql) ? $sql() : $sql;
        return $this;
    }

    public function andWhere(string|callable $sql): self
    {
        if(!$this->where) {
            throw new \Exception('You must call where() before calling andWhere()');
        }
        $this->where .= ' AND ' . (is_callable($sql) ? $sql() : $sql);
        return $this;
    }

    public function orWhere(string|callable $sql): self
    {
        if(!$this->where) {
            throw new \Exception('You must call where() before calling orWhere()');
        }
        $this->where .= ' OR ' . (is_callable($sql) ? $sql() : $sql);
        return $this;
    }

    public function distinct(): self
    {
        if($this->distinct) {
            throw new \Exception('DISTINCT can only be called once');
        }
        $this->distinct = 'DISTINCT';
        return $this;
    }

    //Only in Postgres
    public function distinctOn(string ...$columns): self
    {
        if($this->distinct) {
            throw new \Exception('DISTINCT can only be called once');
        } 

        if($_ENV['DB_CONNECTION'] !== 'pgsql') {
            throw new \Exception('DISTINCT ON is only supported in Postgres');
        }

        $this->distinct = 'DISTINCT ON (' . implode(', ', $columns) . ')';
        return $this;
    }

    public function limit(int $limit): self
    {
        $this->limit = $limit;
        return $this;
    }

    public function offset(int $offset): self
    {
        $this->offset = $offset;
        return $this;
    }

    public function orderBy(string $column, string $direction = 'ASC'): self
    {
        $this->orderBy = 'ORDER BY ' . $column . ' ' . $direction;
        return $this;
    }

    public function get()
    {
        $query = $this->getSql();

        return $query;
    }

    public function getSql(): string
    {
        $query = 'SELECT ';
        $query .= $this->distinct ? $this->distinct . ' ' : '';
        $query .= implode(', ', $this->columns);
        $query .= ' FROM ' . $this->table;
        $query .= $this->where ? ' ' . $this->where : '';
        $query .= $this->orderBy ? ' ' . $this->orderBy : '';
        $query .= $this->limit ? ' LIMIT ' . $this->limit : '';
        $query .= $this->offset ? ' OFFSET ' . $this->offset : '';
        $this->reset();
        return trim($query);        
    }

    protected function reset(): void
    {
        $this->columns = [];
        $this->table = null;
        $this->distinct = null;
        $this->where = null;
        $this->limit = null;
        $this->offset = null;
        $this->orderBy = null;
    }
}
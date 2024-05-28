<?php

declare(strict_types=1);

namespace Yui\ORM\Clauses;

use RuntimeException;
use Yui\Contracts\ORM\Clauses\SelectClauseContract;

class SelectClause implements SelectClauseContract
{
    private const SELECT = 'SELECT ';
    private const DISTINCT = 'DISTINCT';

    protected array $columns = [];
    protected ?string $distinct = null;
    protected ?array $aliases = null;
    protected array $bindings = [];

    public function set(array $data): void
    {
        var_dump($data);
        $this->columns = array_map(function ($column, $index) {
            $this->bindings["column$index"] = $column;
            return ":column$index";
        }, $data['columns'] ?: ['*'], array_keys($data['columns'] ?: ['*']));
        $this->columns = array_unique($this->columns);
    }

    public function distinct(): void
    {
        if ($this->distinct) {
            throw new RuntimeException('DISTINCT can only be called once');
        }
        $this->distinct = self::DISTINCT;
    }

    public function distinctOn(string ...$columns): void
    {
        if ($this->distinct) {
            throw new RuntimeException('DISTINCT can only be called once');
        }

        if ($_ENV['DB_CONNECTION'] !== 'pgsql') {
            throw new RuntimeException('DISTINCT ON is only supported in Postgres');
        }

        $this->distinct = self::DISTINCT . ' ON (' . implode(', ', $columns) . ')';
    }


    public function alias(string $column, string $alias): self
    {
        //If the alias already exists, we will throw an exception
        if (isset($this->aliases[$column])) {
            throw new RuntimeException("Alias for column $column already exists");
        }

        $this->aliases[$column] = $alias;

        $this->bindings["alias_$column"] = $alias;

        return $this;
    }

    public function getSql(): string
    {
        $columns = [];
        foreach ($this->columns as $key => $column) {
            $value = str_replace(':', '', $column);
            $bindColumn = $this->bindings[$value];

            if(isset($this->bindings["alias_$bindColumn"])) {
                $alias = $this->bindings["alias_$bindColumn"];
            }

            if (isset($this->bindings["alias_$bindColumn"])) {
                $columns[] = $column . ' AS ' . $this->bindings["alias_$bindColumn"];
            } else {
                $columns[] = $column;
            }
        }

        return trim(self::SELECT . ($this->distinct ? $this->distinct . ' ' : '') . implode(', ', $columns));
    }

    public function getBindings(): array
    {
        return $this->bindings;
    }
}

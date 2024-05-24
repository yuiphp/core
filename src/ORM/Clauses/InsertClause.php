<?php

declare(strict_types=1);

namespace Yui\ORM\Clauses;

use Exception;
use Yui\Contracts\ORM\Clauses\InsertClauseContract;

class InsertClause implements InsertClauseContract
{
    private const INSERT = 'INSERT INTO ';
    protected string $table;
    protected array $columns = [];
    protected string $values = '';
    protected array $bindings = [];

    public function set(array $data): void
    {
        $this->table = ':table';
        $this->bindings['table'] = $data['table'];
    }

    public function values(array $values): self
    {
        $this->validateValues($values);
        $isMultiDimensional = isset($values[0]) && is_array($values[0]);

        if ($isMultiDimensional) {
            $columns = array_keys($values[0]);
            $this->createColumnPlaceholdersForMultipleRows($columns);
            $this->values = $this->createValuePlaceholdersForMultipleRows($values);
        } else {
            $columns = $values;

            foreach ($columns as $index => $column) {
                $this->bindings["column_$index"] = $column;
                $this->columns[] = ":column_$index";
            }

            $this->columns = array_unique($this->columns);
            $this->values = '(' . implode(', ', $this->columns) . ')';
        }

        return $this;
    }

    public function getSql(): string
    {
        return self::INSERT . "{$this->table} (" . implode(', ', $this->columns) . ") VALUES {$this->values}";
    }

    public function getBindings(): array
    {
        return $this->bindings;
    }

    private function validateValues(array $values): void
    {
        if (empty($values)) {
            throw new Exception('Values cannot be empty');
        }

        if (isset($values[0]) && is_array($values[0])) {
            $columns = array_keys($values[0]);
            foreach ($values as $value) {
                if (array_keys($value) !== $columns) {
                    throw new Exception('All values must have the same keys');
                }
            }
        }
    }

    private function createColumnPlaceholdersForMultipleRows(array $columns): void
    {
        foreach ($columns as $index => $column) {
            $this->bindings["column_$column"] = $column;
            $this->columns[] = ":column_$column";
        }
    }

    private function createValuePlaceholdersForMultipleRows(array $values): string
    {
        $valuesStr = '';
        foreach ($values as $index => $value) {
            $placeholders = [];
            foreach ($value as $column => $val) {
                $placeholder = ":column_$column" . $index;
                $this->bindings["column_$column" . $index] = $val;
                $placeholders[] = $placeholder;
            }
            $valuesStr .= '(' . implode(', ', $placeholders) . '), ';
        }
        return rtrim($valuesStr, ', ');
    }
}

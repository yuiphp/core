<?php

declare(strict_types=1);

namespace Yui\ORM\Builders\Delete;

class DeleteBuilder
{
    protected string $table;
    protected array $columns = [];
    protected array $values = [];

    public function __construct(string $table)
    {
        $this->table = $table;
    }

    // public function set(string $column, mixed $value): self
    // {
    // 	$this->columns[] = $column;
    // 	$this->values[] = $value;

    // 	return $this;
    // }

    // public function get()
    // {
    // 	$query = $this->getSql();

    // 	return $query;
    // }

    // public function getSql(): string
    // {
    // 	$query = 'UPDATE ' . $this->table . ' SET ';
    // 	$query .= implode(', ', array_map(fn($column, $value) => "$column = $value", $this->columns, $this->values));
    // 	return trim($query);
    // }
}

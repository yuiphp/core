<?php

declare(strict_types=1);

namespace Yui\ORM\Clauses;

use RuntimeException;
use Yui\Contracts\ORM\Clauses\GroupByClauseContract;

class GroupByClause implements GroupByClauseContract
{
    private const GROUP_BY = 'GROUP BY ';
    private const HAVING = ' HAVING ';
    protected ?array $columns = null;
    protected ?string $having = null;
    protected array $bindings = [];

    public function set(array $data): void
    {
        $this->columns = array_map(function ($column, $index) {
            $this->bindings["groupByColumn$index"] = $column;
            return ":groupByColumn$index";
        }, $data['groupByColumns'], array_keys($data['groupByColumns']));
    }

    public function having(string $sql): self
    {
        if (!$this->columns) {
            throw new RuntimeException('You must call groupBy() before calling having()');
        }

        $this->having = ':having';
        $this->bindings['having'] = $sql;
        return $this;
    }

    public function getSql(): string
    {
        $sql = $this->columns ? self::GROUP_BY . implode(', ', $this->columns) : '';
        $sql .= $this->having ? self::HAVING . $this->having : '';
        return $sql;
    }

    public function getBindings(): array
    {
        return $this->bindings;
    }
}

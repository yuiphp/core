<?php

declare(strict_types=1);

namespace Yui\ORM\Clauses;

use Yui\Contracts\ORM\Clauses\ClauseContract;

class OrderByClause implements ClauseContract
{
    private const ORDER_BY = 'ORDER BY ';

    protected ?string $column = null;
    protected ?string $direction = null;
    protected array $bindings = [];

    public function set(array $data): void
    {
        $this->column = ':orderByColumn';
        $this->direction = ':direction';
        $this->bindings['orderByColumn'] = $data['orderByColumn'];
        $this->bindings['direction'] = $data['direction'];
    }

    public function getSql(): string
    {
        return $this->column ? self::ORDER_BY . $this->column . ' ' . $this->direction : '';
    }

    public function getBindings(): array
    {
        return $this->bindings;
    }
}

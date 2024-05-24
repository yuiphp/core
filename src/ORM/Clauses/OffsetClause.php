<?php

declare(strict_types=1);

namespace Yui\ORM\Clauses;

use Yui\Contracts\ORM\Clauses\ClauseContract;

class OffsetClause implements ClauseContract
{
    private const OFFSET = 'OFFSET ';
    protected ?string $offset = null;
    protected array $bindings = [];

    public function set(array $data): void
    {
        $this->offset = ':offset';
        $this->bindings['offset'] = $data['offset'];
    }

    public function getSql(): string
    {
        return $this->offset ? self::OFFSET . $this->offset : '';
    }

    public function getBindings(): array
    {
        return $this->bindings;
    }
}

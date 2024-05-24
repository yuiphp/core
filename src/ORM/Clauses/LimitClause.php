<?php

declare(strict_types=1);

namespace Yui\ORM\Clauses;

use Yui\Contracts\ORM\Clauses\ClauseContract;

class LimitClause implements ClauseContract
{
    private const LIMIT = 'LIMIT ';

    protected ?string $limit = null;
    protected array $bindings = [];

    public function set(array $data): void
    {
        $this->limit = ':limit';
        $this->bindings['limit'] = $data['limit'];
    }

    public function getSql(): string
    {
        return $this->limit ? self::LIMIT . $this->limit : '';
    }

    public function getBindings(): array
    {
        return $this->bindings;
    }
}

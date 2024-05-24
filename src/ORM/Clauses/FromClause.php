<?php

declare(strict_types=1);

namespace Yui\ORM\Clauses;

use Yui\Contracts\ORM\Clauses\ClauseContract;

class FromClause implements ClauseContract
{
    private const FROM = 'FROM ';

    protected ?string $table = null;
    protected ?string $alias = null;
    protected array $bindings = [];

    public function set(array $data): void
    {
        $this->table = ':table';
        $this->alias = $data['alias'] ?? null;
        $this->bindings['table'] = $data['table'];
        if ($this->alias) {
            $this->bindings['alias'] = $this->alias;
        }
    }

    public function getSql(): string
    {
        return self::FROM . $this->table . ($this->alias ? ' AS :alias' : '');
    }

    public function getBindings(): array
    {
        return $this->bindings;
    }
}

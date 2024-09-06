<?php

declare(strict_types=1);

namespace Yui\ORM\Clauses;

use RuntimeException;
use Yui\Contracts\ORM\Clauses\WhereClauseContract;

class WhereClause implements WhereClauseContract
{
    private const AND = ' AND';
    private const OR = ' OR';

    protected ?string $where = null;
    protected array $bindings = [];

    public function set(array $data): void
    {
        $this->where = 'WHERE :where';

        $data['sql'] = $this->removeKeywords($data['sql']);

        $this->bindings['where'] = $data['sql'];
    }

    public function and(string $sql): self
    {
        $this->validateWhereClauseExists();

        $sql = $this->removeKeywords($sql);

        $this->where .= self::AND . ' :and';

        $this->bindings['and'] = $sql;
        return $this;
    }

    public function or(string $sql): self
    {
        $this->validateWhereClauseExists();

        $sql = $this->removeKeywords($sql);

        $this->where .= self::OR . ' :or';

        $this->bindings['or'] = $sql;
        return $this;
    }

    public function getSql(): string
    {
        return trim($this->where ?: '');
    }

    public function getBindings(): array
    {
        echo PHP_EOL;
        var_dump($this->bindings);
        echo PHP_EOL;
        return $this->bindings;
    }

    protected function removeKeywords(string $sql): string
    {
        return str_replace(['AND ', 'OR ', 'and ', 'or ', 'WHERE ', 'where '], '', $sql);
    }

    protected function validateWhereClauseExists(): void
    {
        if (!$this->where) {
            throw new RuntimeException('You must call where() before calling andWhere() or orWhere()');
        }
    }
}

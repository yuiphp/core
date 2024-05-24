<?php

declare(strict_types=1);

namespace Yui\Contracts\ORM\Clauses;

interface SelectClauseContract extends ClauseContract
{
    public function distinct(): void;
    public function distinctOn(string $column): void;
    public function alias(string $column, string $alias): self;
}

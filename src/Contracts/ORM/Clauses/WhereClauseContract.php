<?php

declare(strict_types=1);

namespace Yui\Contracts\ORM\Clauses;

interface WhereClauseContract extends ClauseContract
{
    public function and(string $sql): self;
    public function or(string $sql): self;
}

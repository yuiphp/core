<?php

declare(strict_types=1);

namespace Yui\Contracts\ORM\Clauses;

interface InsertClauseContract extends ClauseContract
{
    public function values(array $values): self;
}
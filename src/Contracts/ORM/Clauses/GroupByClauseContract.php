<?php

declare(strict_types=1);

namespace Yui\Contracts\ORM\Clauses;

interface GroupByClauseContract extends ClauseContract
{
    public function having(string $sql): self;
}

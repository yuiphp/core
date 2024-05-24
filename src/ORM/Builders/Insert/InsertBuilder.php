<?php

declare(strict_types=1);

namespace Yui\ORM\Builders\Insert;

use Yui\Contracts\ORM\Clauses\ClauseContract;
use Yui\ORM\Clauses\InsertClause;

class InsertBuilder
{
    /** @var array<InsertClause> */
    private array $clauses = [

    ];

    public function __construct(string $table)
    {
        $this->clauses['insert'] = new InsertClause();
        $this->clauses['insert']->set(['table' => $table]);
    }

    public function values(array $values): self
    {
        $this->clauses['insert']->values($values);
        return $this;
    }

    public function returning(string ...$columns): self
    {

        return $this;
    }
}

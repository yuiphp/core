<?php

declare(strict_types=1);

namespace Yui\Contracts\ORM\Clauses;


interface ClauseContract
{
	public function setValues(string ...$values): void;
	public function getClause(): string;
}
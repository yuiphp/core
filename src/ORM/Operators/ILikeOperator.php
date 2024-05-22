<?php

declare(strict_types=1);

namespace Yui\ORM\Operators;

function ilike(string $column, mixed $value): string
{
    return "WHERE $column ILIKE '%$value%' ";
}

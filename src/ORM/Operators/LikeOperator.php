<?php

declare(strict_types=1);

namespace Yui\ORM\Operators;

function like(string $column, mixed $value): string
{
    return "WHERE $column LIKE '%$value%' ";
}

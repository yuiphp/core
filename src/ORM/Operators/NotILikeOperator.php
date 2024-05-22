<?php

declare(strict_types=1);

namespace Yui\ORM\Operators;

function notIlike(string $column, mixed $value): string
{
    return "WHERE $column NOT ILIKE '$value' ";
}

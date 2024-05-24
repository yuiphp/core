<?php

declare(strict_types=1);

namespace Yui\ORM\Operators;

function like(string $column, mixed $value): string
{
    $value = is_string($value) ? "'$value'" : $value;
    return "$column LIKE $value ";
}

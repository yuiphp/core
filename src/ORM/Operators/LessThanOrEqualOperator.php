<?php

declare(strict_types=1);

namespace Yui\ORM\Operators;

function lte(string $column, mixed $value): string
{
    $value = is_string($value) ? "'$value'" : $value;
    return "$column <= $value ";
}

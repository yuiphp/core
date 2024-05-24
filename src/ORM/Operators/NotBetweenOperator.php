<?php

declare(strict_types=1);

namespace Yui\ORM\Operators;

function notBetween(string $column, mixed $value1, mixed $value2): string
{
    $value1 = is_string($value1) ? "'$value1'" : $value1;
    $value2 = is_string($value2) ? "'$value2'" : $value2;
    return "$column NOT BETWEEN $value1 AND $value2 ";
}

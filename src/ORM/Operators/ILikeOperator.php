<?php

declare(strict_types=1);

namespace Yui\ORM\Operators;

function ilike(string $column, mixed $value): string
{
    $value = is_string($value) ? "'$value'" : $value;
    if($_ENV['DB_CONNECTION'] === 'pgsql') {
        return "$column ILIKE $value ";
    }

    return " $column LIKE $value ";
}

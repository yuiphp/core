<?php

declare(strict_types=1);

namespace Yui\ORM\Operators;

function inArray(string $column, array $values): string
{
    $values = implode(', ', array_map(fn ($value) => is_string($value) ? "'$value'" : $value, $values));
    return "$column IN ($values) ";
}

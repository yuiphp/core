<?php

declare(strict_types=1);

namespace Yui\ORM\Operators;

function notInArray(string $column, array $values): string
{
    $values = implode(", ", $values);
    return "$column NOT IN ($values) ";
}

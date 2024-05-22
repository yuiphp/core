<?php

declare(strict_types=1);

namespace Yui\ORM\Operators;

function notBetween(string $column, mixed $value1, mixed $value2): string
{
    return "WHERE $column NOT BETWEEN '$value1' AND '$value2' ";
}

<?php

declare(strict_types=1);

namespace Yui\ORM\Operators;

function between(string $column, mixed $value1, mixed $value2): string
{
    return "WHERE $column BETWEEN '$value1' AND '$value2' ";
}

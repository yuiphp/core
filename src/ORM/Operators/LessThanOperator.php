<?php

declare(strict_types=1);

namespace Yui\ORM\Operators;

function lt(string $column, mixed $value): string
{
    return "WHERE $column < '$value' ";
}
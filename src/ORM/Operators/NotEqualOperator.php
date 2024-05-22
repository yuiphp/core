<?php

declare(strict_types=1);

namespace Yui\ORM;

function neq(string $column, mixed $value): string
{
    return "WHERE $column != '$value' ";
}

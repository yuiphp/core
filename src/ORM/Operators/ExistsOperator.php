<?php

declare(strict_types=1);

namespace Yui\ORM\Operators;

function exists(string $column, string $query): string
{
    return "WHERE EXISTS ($query) ";
}

<?php

declare(strict_types=1);

namespace Yui\ORM\Operators;

function notExists(string $column, string $query): string
{
    return "WHERE NOT EXISTS ($query) ";
}

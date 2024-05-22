<?php

declare(strict_types=1);

namespace Yui\ORM\Operators;

function isNull(string $column): string
{
    return "WHERE $column IS NULL ";
}
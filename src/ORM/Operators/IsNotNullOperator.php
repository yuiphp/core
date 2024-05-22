<?php

declare(strict_types=1);

namespace Yui\ORM\Operators;

function isNotNull(string $column): string
{
    return "WHERE $column IS NOT NULL ";
}


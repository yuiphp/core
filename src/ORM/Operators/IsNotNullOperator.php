<?php

declare(strict_types=1);

namespace Yui\ORM\Operators;

function isNotNull(string $column): string
{
    return "$column IS NOT NULL ";
}

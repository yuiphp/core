<?php

declare(strict_types=1);

namespace Yui\ORM\Operators;

function isNull(string $column): string
{
    return "$column IS NULL ";
}

<?php

declare(strict_types=1);

namespace Yui\ORM\Operators;

function notExists(string $query): string
{
    return "NOT EXISTS ($query) ";
}

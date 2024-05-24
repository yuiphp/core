<?php

declare(strict_types=1);

namespace Yui\ORM\Operators;

function exists(string $query): string
{
    return "EXISTS ($query) ";
}

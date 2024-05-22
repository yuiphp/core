<?php

declare(strict_types=1);

namespace Yui\ORM\Operators;

function inArray(string $column, array $values): string
{
    return "WHERE $column IN ('" . implode("', '", $values) . "') "; //Where $column in ('value1', 'value2', 'value3')
}
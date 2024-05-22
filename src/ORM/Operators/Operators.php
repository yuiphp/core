<?php

declare(strict_types=1);

namespace Yui\ORM\Operators;

// Load all operators
foreach (glob(__DIR__ . "/*.php") as $filename)
{
    require_once $filename;
}
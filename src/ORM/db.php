<?php

declare(strict_types=1);

namespace Yui\ORM;

function db(): QueryBuilder
{
    return new QueryBuilder();
}

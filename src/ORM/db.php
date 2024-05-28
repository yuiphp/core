<?php

declare(strict_types=1);

namespace Yui\ORM;

use Yui\Application;
use Yui\Database\DB;

function db(): QueryBuilder
{
    $databaseHandler = Application::getInstance()->container->get(DB::class);
    return new QueryBuilder($databaseHandler);
}

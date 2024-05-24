<?php

declare(strict_types=1);

namespace Yui\ORM;

use Yui\Application;

function db(): QueryBuilder
{
    $application = Application::getInstance();
    return new QueryBuilder($application);
}

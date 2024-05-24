<?php

declare(strict_types=1);

namespace Yui\Container;

use Psr\Container\ContainerInterface;
use Yui\Database\Connection\DatabaseConnection;
use Yui\Database\DB;

return [
    DatabaseConnection::class => \DI\create(DatabaseConnection::class),
    DB::class => \DI\factory(function (ContainerInterface $c) {
        return new DB($c->get(DatabaseConnection::class));
    }),
];

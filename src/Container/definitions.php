<?php

declare(strict_types=1);

namespace Yui\Container;

use Exception;
use Yui\Contracts\Database\Driver\DriverContract;
use Yui\Database\Connection\Drivers\MysqlDriver;
use Yui\Database\Connection\Drivers\PgsqlDriver;
use Yui\Database\Connection\Drivers\SqliteDriver;

return [
    DriverContract::class => function () {
        switch ($_ENV['DB_CONNECTION']) {
            case 'mysql':
                return new MysqlDriver;
            case 'pgsql':
                return new PgsqlDriver;
            case 'sqlite':
                return new SqliteDriver;
            default:
                throw new Exception('Invalid database driver');
        }
    },
];

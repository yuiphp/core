<?php

declare(strict_types=1);

namespace Yui\Container;

use Psr\Container\ContainerInterface;
use Yui\Contracts\Database\Driver\DriverContract;
use Yui\Database\Connection\DatabaseConnection;
use Yui\Database\Connection\Drivers\MysqlDriver;
use Yui\Database\Connection\Drivers\PgsqlDriver;
use Yui\Database\Connection\Drivers\SqliteDriver;
use Yui\Database\DB;

use function DI\factory;
use function DI\create;

return [
    DriverContract::class =>  factory(function () {
        return match ($_ENV['DB_CONNECTION']) {
            'mysql' => new MySQLDriver(),
            'pgsql' => new PgSQLDriver(),
            'sqlite' => new SqliteDriver(),
            default => throw new \RuntimeException('Driver not found'),
        };
    }),
    DatabaseConnection::class => create(DatabaseConnection::class),
    DB::class => factory(function(){
        return DB::getInstance();
    }),
];

<?php

use Yui\Database\Connection\Connection;
use Yui\Contracts\Database\Driver\DriverContract;

it('tests connection', function () {
    $pdo = Mockery::mock(PDO::class);
    $driver = Mockery::mock(DriverContract::class);
    $driver->shouldReceive('connect')->andReturn($pdo);

    $connection = new Connection($driver);

    $this->assertSame($pdo, $connection->connect());
    $this->assertSame($pdo, $connection->connect());
});
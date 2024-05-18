<?php

use Yui\Database\Connection\Drivers\SqliteDriver;

it('tests sqlite driver connection', function () {
    $driver = Mockery::mock(SqliteDriver::class)->makePartial()->shouldAllowMockingProtectedMethods();
    $driver->shouldReceive('getEnv')->andReturn(__DIR__);
    $driver->shouldReceive('createPDO')->andReturn(Mockery::mock(PDO::class));

    $pdo = $driver->connect();

    $this->assertInstanceOf(PDO::class, $pdo);
});

it('tests sqlite driver connection with invalid path', function () {
    $driver = Mockery::mock(SqliteDriver::class)->makePartial()->shouldAllowMockingProtectedMethods();
    $driver->shouldReceive('getEnv')->andReturn('invalid_path');

    $this->expectException(Exception::class);
    $this->expectExceptionMessage('Invalid path to SQLite database');

    $driver->connect();
});
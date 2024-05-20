<?php

use Yui\Database\Connection\Drivers\PgsqlDriver;

it('tests pgsql driver connection', function () {
    $driver = Mockery::mock(PgsqlDriver::class)->makePartial()->shouldAllowMockingProtectedMethods();
    $driver->shouldReceive('getEnv')->andReturn('test_value');
    $driver->shouldReceive('createPDO')->andReturn(Mockery::mock(PDO::class));

    $pdo = $driver->connect();

    $this->assertInstanceOf(PDO::class, $pdo);
});
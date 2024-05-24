<?php

use Yui\Database\Connection\Drivers\MysqlDriver;

it('tests mysql driver connection', function () {
    $driver = Mockery::mock(MysqlDriver::class)->makePartial()->shouldAllowMockingProtectedMethods();
    $driver->shouldReceive('getEnv')->andReturn('test_value');
    $driver->shouldReceive('createPDO')->andReturn(Mockery::mock(PDO::class));

    $pdo = $driver->connect();

    $this->assertInstanceOf(PDO::class, $pdo);
});

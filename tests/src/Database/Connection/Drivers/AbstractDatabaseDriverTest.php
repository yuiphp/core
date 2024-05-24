<?php

use Yui\Database\Connection\Drivers\AbstractDatabaseDriver;

class TestableDatabaseDriver extends AbstractDatabaseDriver
{
    public function connect(): PDO
    {
        // Fictional implementation for testing purposes
        return new PDO('sqlite::memory:');
    }

    public function createPDO(string $dsn, ?string $username = null, ?string $password = null): PDO
    {
        return parent::createPDO($dsn, $username, $password);
    }

    public function getEnv(string $key): string
    {
        return parent::getEnv($key);
    }
}

it('tests createPDO method', function () {
    $driver = new TestableDatabaseDriver();
    $pdo = $driver->createPDO('sqlite::memory:');
    $this->assertInstanceOf(PDO::class, $pdo);
});

it('tests getEnv method', function () {
    $_ENV['DB_TEST'] = 'test_value';
    $driver = new TestableDatabaseDriver();
    $value = $driver->getEnv('DB_TEST');
    $this->assertEquals('test_value', $value);
});

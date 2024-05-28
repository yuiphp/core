<?php

use Yui\Database\Connection\DatabaseConnection;
use Yui\Database\Connection\Drivers\MysqlDriver;
use Yui\Database\Connection\Drivers\PgsqlDriver;
use Yui\Database\Connection\Drivers\SqliteDriver;

beforeEach(function () {
    $this->pdoMock = Mockery::mock(PDO::class);
});

afterEach(function () {
    Mockery::close();
});

it('connects using the mysql driver', function () {
    $mockDriver = Mockery::mock(MysqlDriver::class);
    $mockDriver->expects('connect')->andReturns($this->pdoMock);

    $dbConnection = new DatabaseConnection($mockDriver);

    expect($dbConnection->connect())->toBe($this->pdoMock);
});

it('connects using the pgsql driver', function () {
    $mockDriver = Mockery::mock(PgsqlDriver::class);
    $mockDriver->expects('connect')->andReturns($this->pdoMock);

    $dbConnection = new DatabaseConnection($mockDriver);

    expect($dbConnection->connect())->toBe($this->pdoMock);
});

it('connects using the sqlite driver', function () {
    $mockDriver = Mockery::mock(SqliteDriver::class);
    $mockDriver->expects('connect')->andReturns($this->pdoMock);

    $dbConnection = new DatabaseConnection($mockDriver);

    expect($dbConnection->connect())->toBe($this->pdoMock);
});

it('throws an exception for an invalid driver', function () {
    $dbConnection = new DatabaseConnection(new InvalidDriver());
    
    $dbConnection->connect();
})->throws(Exception::class, 'Invalid database driver');

class InvalidDriver implements \Yui\Contracts\Database\Driver\DriverContract
{
    public function connect(): PDO
    {
        return new PDO('sqlite::memory:');
    }
}
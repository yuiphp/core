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
    $mockDriver->shouldReceive('connect')->once()->andReturn($this->pdoMock);

    $dbConnection = new DatabaseConnection();
    $dbConnection->setDriver($mockDriver);

    expect($dbConnection->connect())->toBe($this->pdoMock);
});

it('connects using the pgsql driver', function () {
    $mockDriver = Mockery::mock(PgsqlDriver::class);
    $mockDriver->shouldReceive('connect')->once()->andReturn($this->pdoMock);

    $dbConnection = new DatabaseConnection();
    $dbConnection->setDriver($mockDriver);

    expect($dbConnection->connect())->toBe($this->pdoMock);
});

it('connects using the sqlite driver', function () {
    $mockDriver = Mockery::mock(SqliteDriver::class);
    $mockDriver->shouldReceive('connect')->once()->andReturn($this->pdoMock);

    $dbConnection = new DatabaseConnection();
    $dbConnection->setDriver($mockDriver);

    expect($dbConnection->connect())->toBe($this->pdoMock);
});

it('throws an exception for an invalid driver', function () {
    $dbConnection = new DatabaseConnection();

    $dbConnection->connect();
})->throws(Exception::class, 'Invalid database driver');

<?php

use Yui\Database\Connection\DatabaseConnection;
use Yui\Database\DB;

beforeEach(function () {
    $this->pdoMock = Mockery::mock(PDO::class);
    $this->pdoStatementMock = Mockery::mock(PDOStatement::class);
    $this->dbConnectionMock = Mockery::mock(DatabaseConnection::class);
    $this->dbConnectionMock->shouldReceive('connect')->andReturn($this->pdoMock);
});

it('constructs without throwing an exception', function () {
    $db = new DB($this->dbConnectionMock);
    expect($db)->toBeInstanceOf(DB::class);
});

it('runs a query successfully', function () {
    $this->pdoMock->shouldReceive('exec')->andReturn(1);

    $db = new DB($this->dbConnectionMock);
    $affectedRows = $db->runQuery('UPDATE users SET name = "John" WHERE id = 1');

    expect($affectedRows)->toBe(1);
});

it('gets a query successfully', function () {
    $this->pdoMock->shouldReceive('prepare')->andReturn($this->pdoStatementMock);
    $this->pdoStatementMock->shouldReceive('setFetchMode')->with(PDO::FETCH_OBJ);
    $this->pdoStatementMock->shouldReceive('execute');

    $db = new DB($this->dbConnectionMock);
    $stmt = $db->getQuery('SELECT * FROM users');

    expect($stmt)->toBe($this->pdoStatementMock);
});

it('throws an exception when there is an error running a query', function () {
    $this->pdoMock->shouldReceive('exec')->andThrow(new PDOException('Error running query'));

    $db = new DB($this->dbConnectionMock);
    $db->runQuery('UPDATE users SET name = "John" WHERE id = 1');
})->throws(Exception::class, 'Error running query: Error running query');

it('throws an exception when there is an error getting a query', function () {
    $this->pdoMock->shouldReceive('prepare')->andThrow(new PDOException('Error running query'));

    $db = new DB($this->dbConnectionMock);
    $db->getQuery('SELECT * FROM users');
})->throws(Exception::class, 'Error running query: Error running query');

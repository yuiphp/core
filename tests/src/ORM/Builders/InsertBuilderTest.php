<?php

use Yui\ORM\Builders\Insert\InsertBuilder;

afterEach(function () {
    Mockery::close();
});

it('should insert a record into the database', function () {
    $mockPdoStatement = Mockery::mock(\PDOStatement::class);
    $mockPdoStatement->allows('execute')->andReturns(true);

    $mockPdo = Mockery::mock(\PDO::class);
    $mockPdo->allows('prepare')->andReturns($mockPdoStatement);
    $mockPdo->allows('execute')->andReturns(true);
    $mockPdo->allows('getDbh')->andReturns($mockPdo);
    $mockPdo->allows('lastInsertId')->andReturns(1);
    $mockPdo->allows('rollback')->andReturns(true);
    $mockPdo->allows('commit')->andReturns(true);
    $mockPdo->allows('beginTransaction')->andReturns(true);

    $mockDb = Mockery::mock(\Yui\Database\DB::class);
    $mockDb->allows('getDbh')->andReturns($mockPdo);

    $insertBuilder = new InsertBuilder('users', $mockDb);

    expect($insertBuilder->valuesGetId([
        'name' => 'John Doe',
        'email' => 'john@email.com'
    ]))->toBe(1);
});
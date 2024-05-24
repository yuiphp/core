<?php

declare(strict_types=1);

use Yui\ORM\Clauses\InsertClause;

it('should return the correct select SQL insert one row', function () {
    $insert = new InsertClause();
    $insert->set(['table' => 'users']);
    $insert->values(['name' => 'John Doe', 'email' => 'john@gmail']);

    expect($insert->getSql())->toBe("INSERT INTO :table (:column_name, :column_email) VALUES (:column_name, :column_email)");
});

it('should return the correct select bindings insert one row', function () {
    $insert = new InsertClause();
    $insert->set(['table' => 'users']);
    $insert->values(['name' => 'John Doe', 'email' => 'john@gmail']);

    expect($insert->getBindings())->toBe(['table' => 'users', 'column_name' => 'John Doe', 'column_email' => 'john@gmail']);
});

it('should insert multiple rows', function () {
    $insert = new InsertClause();
    $insert->set(['table' => 'users']);
    $insert->values([
        ['name' => 'John Doe', 'email' => 'john@gmail'],
        ['name' => 'Jane Doe', 'email' => 'jane@gmail'],
    ]);

    expect($insert->getSql())->toBe("INSERT INTO :table (:column_name, :column_email) VALUES (:column_name0, :column_email0), (:column_name1, :column_email1)");
});

it('should return the correct select bindings insert multiple rows', function () {
    $insert = new InsertClause();
    $insert->set(['table' => 'users']);
    $insert->values([
        ['name' => 'John Doe', 'email' => 'john@gmail'],
        ['name' => 'Jane Doe', 'email' => 'jane@gmail'],
    ]);

    expect($insert->getBindings())->toBe([
        'table' => 'users',
        'column_name' => 'name',
        'column_email' => 'email',
        'column_name0' => 'John Doe',
        'column_email0' => 'john@gmail',
        'column_name1' => 'Jane Doe',
        'column_email1' => 'jane@gmail',
    ]);
});
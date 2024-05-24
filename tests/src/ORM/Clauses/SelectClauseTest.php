<?php

declare(strict_types=1);

use Yui\ORM\Clauses\SelectClause;

it('should return the correct select SQL', function () {
    $select = new SelectClause();
    $select->set(['columns' => ['id', 'name']]);
    expect($select->getSql())->toBe('SELECT :column0, :column1');
});

it('should return the correct select bindings', function () {
    $select = new SelectClause();
    $select->set(['columns' => ['id', 'name']]);
    expect($select->getBindings())->toBe(['column0' => 'id', 'column1' => 'name']);
});

it('should return the correct select SQL with alias', function () {
    $select = new SelectClause();
    $select->set(['columns' => ['id', 'name']]);
    $select->alias('name', 'u');
    expect($select->getSql())->toBe('SELECT :column0, :column1 AS u');
});

it('should return the correct select bindings with alias', function () {
    $select = new SelectClause();
    $select->set(['columns' => ['id', 'name', 'email']]);
    $select->alias('name', 'u');
    $select->alias('email', 'e');
    expect($select->getBindings())->toBe(['column0' => 'id', 'column1' => 'name', 'column2' => 'email','alias_name' => 'u', 'alias_email' => 'e']);
});

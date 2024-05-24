<?php

declare(strict_types=1);

use Yui\ORM\Clauses\WhereClause;

it('should return a where clause', function () {
    $where = new WhereClause();

    $where->set(['sql' => 'id = 1']);

    expect($where->getSql())->toBe('WHERE :where');
});

it("should return the correct where bindings", function () {
    $where = new WhereClause();

    $where->set(['sql' => 'id = 1']);

    expect($where->getBindings())->toBe(['where' => 'id = 1']);
});

it('should return the correct where SQL with AND', function () {
    $where = new WhereClause();

    $where->set(['sql' => 'id = 1']);
    $where->and('name = "John"');

    expect($where->getSql())->toBe('WHERE :where AND :and');
});

it('should return the correct where bindings with AND', function () {
    $where = new WhereClause();

    $where->set(['sql' => 'id = 1']);
    $where->and('name = "John"');

    expect($where->getBindings())->toBe(['where' => 'id = 1', 'and' => 'name = "John"']);
});

it('should return the correct where SQL with OR', function () {
    $where = new WhereClause();

    $where->set(['sql' => 'id = 1']);
    $where->or('name = "John"');

    expect($where->getSql())->toBe('WHERE :where OR :or');
});

it('should return the correct where bindings with OR', function () {
    $where = new WhereClause();

    $where->set(['sql' => 'id = 1']);
    $where->or('name = "John"');

    expect($where->getBindings())->toBe(['where' => 'id = 1', 'or' => 'name = "John"']);
});

it('should return the correct where SQL with AND and OR', function () {
    $where = new WhereClause();

    $where->set(['sql' => 'id = 1']);
    $where->and('name = "John"');
    $where->or('email = "john@gmail.com"');

    expect($where->getSql())->toBe('WHERE :where AND :and OR :or');
});

it('should return the correct where bindings with AND and OR', function () {
    $where = new WhereClause();

    $where->set(['sql' => 'id = 1']);
    $where->and('name = "John"');
    $where->or('email = "john@gmail.com"');

    expect($where->getBindings())->toBe(['where' => 'id = 1', 'and' => 'name = "John"', 'or' => 'email = "john@gmail.com"']);
});

it('Cannot return duplicate where, and or bindings', function () {
    $where = new WhereClause();

    $where->set(['sql' => 'id = 1']);
    $where->and('AND name = "John"');
    $where->or('OR email = "john@gmail.com"');

    expect($where->getBindings())->toBe(['where' => 'id = 1', 'and' => 'name = "John"', 'or' => 'email = "john@gmail.com"']);
});

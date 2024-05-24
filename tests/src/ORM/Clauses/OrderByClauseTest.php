<?php

declare(strict_types=1);

use Yui\ORM\Clauses\OrderByClause;

it('should return the correct order by SQL', function () {
    $orderBy = new OrderByClause();
    $orderBy->set(['orderByColumn' => 'id', 'direction' => 'ASC']);
    expect($orderBy->getSql())->toBe('ORDER BY :orderByColumn :direction');
});

it('should return the correct order by bindings', function () {
    $orderBy = new OrderByClause();
    $orderBy->set(['orderByColumn' => 'id', 'direction' => 'ASC']);
    expect($orderBy->getBindings())->toBe(['orderByColumn' => 'id', 'direction' => 'ASC']);
});

it('should return the correct order by SQL with multiple columns', function () {
    $orderBy = new OrderByClause();
    $orderBy->set(['orderByColumn' => ['id', 'name'], 'direction' => 'ASC']);
    expect($orderBy->getSql())->toBe('ORDER BY :orderByColumn :direction');
});

it('should return the correct order by bindings with multiple columns', function () {
    $orderBy = new OrderByClause();
    $orderBy->set(['orderByColumn' => ['id', 'name'], 'direction' => 'ASC']);
    expect($orderBy->getBindings())->toBe(['orderByColumn' => ['id', 'name'], 'direction' => 'ASC']);
});

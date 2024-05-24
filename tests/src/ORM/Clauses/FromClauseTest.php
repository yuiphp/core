<?php

declare(strict_types=1);

use Yui\ORM\Clauses\FromClause;

it('should return the correct SQL without Alias', function () {
    $from = new FromClause();
    $from->set(['table' => 'users']);
    expect($from->getSql())->toBe('FROM :table');
});

it('should return the correct SQL with Alias', function () {
    $from = new FromClause();
    $from->set(['table' => 'users', 'alias' => 'u']);
    expect($from->getSql())->toBe('FROM :table AS :alias');
});

it('should return the correct bindings', function () {
    $from = new FromClause();
    $from->set(['table' => 'users', 'alias' => 'u']);
    expect($from->getBindings())->toBe(['table' => 'users', 'alias' => 'u']);
});

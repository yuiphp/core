<?php

declare(strict_types=1);

use Yui\ORM\Clauses\LimitClause;

it('should return the correct limit SQL', function () {
    $limit = new LimitClause();
    $limit->set(['limit' => 10]);
    expect($limit->getSql())->toBe('LIMIT :limit');
});

it('should return the correct limit bindings', function () {
    $limit = new LimitClause();
    $limit->set(['limit' => 10]);
    expect($limit->getBindings())->toBe(['limit' => 10]);
});

<?php

declare(strict_types=1);

use Yui\ORM\Clauses\OffsetClause;

it('should return the correct offset SQL', function () {
    $offset = new OffsetClause();
    $offset->set(['offset' => 10]);
    expect($offset->getSql())->toBe('OFFSET :offset');
});

it('should return the correct offset bindings', function () {
    $offset = new OffsetClause();
    $offset->set(['offset' => 10]);
    expect($offset->getBindings())->toBe(['offset' => 10]);
});

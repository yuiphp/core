<?php

declare(strict_types=1);

use Yui\ORM\Clauses\GroupByClause;

it('should return the correct SQL', function () {
    $groupBy = new GroupByClause();
    $groupBy->set(['groupByColumns' => ['id', 'name', 'email']]);
    expect($groupBy->getSql())->toBe('GROUP BY :groupByColumn0, :groupByColumn1, :groupByColumn2');
});

it('should return the correct bindings', function () {
    $groupBy = new GroupByClause();
    $groupBy->set(['groupByColumns' => ['id', 'name', 'email']]);
    expect($groupBy->getBindings())->toBe(['groupByColumn0' => 'id', 'groupByColumn1' => 'name', 'groupByColumn2' => 'email']);

});

it('should return the correct SQL with having', function () {
    $groupBy = new GroupByClause();
    $groupBy->set(['groupByColumns' => ['id', 'name', 'email']]);
    $groupBy->having('COUNT(id) > 1');
    expect($groupBy->getSql())->toBe('GROUP BY :groupByColumn0, :groupByColumn1, :groupByColumn2 HAVING :having');
});

it('should return the correct bindings with having', function () {
    $groupBy = new GroupByClause();
    $groupBy->set(['groupByColumns' => ['id', 'name', 'email']]);
    $groupBy->having('COUNT(id) > 1');
    expect($groupBy->getBindings())->toBe(['groupByColumn0' => 'id', 'groupByColumn1' => 'name', 'groupByColumn2' => 'email', 'having' => 'COUNT(id) > 1']);
});

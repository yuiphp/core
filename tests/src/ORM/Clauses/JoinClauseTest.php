<?php

declare(strict_types=1);

use Yui\ORM\Clauses\JoinClause;

use function Yui\ORM\Operators\eq;

it('should return the correct left join SQL', function () {
    $join = new JoinClause();
    $join->leftJoin('users', eq("users.id", "posts.user_id"));
    expect($join->getSql())->toBe('LEFT JOIN :JoinTable ON :sql');
});

it('should return the correct left join bindings', function () {
    $join = new JoinClause();
    $join->leftJoin('users', eq("users.id", "posts.user_id"));
    expect($join->getBindings())->toBe(['JoinTable' => 'users', 'sql' => "users.id = 'posts.user_id' "]);
});

it('should return the correct right join SQL', function () {
    $join = new JoinClause();
    $join->rightJoin('users', eq("users.id", "posts.user_id"));
    expect($join->getSql())->toBe('RIGHT JOIN :JoinTable ON :sql');
});

it('should return the correct right join bindings', function () {
    $join = new JoinClause();
    $join->rightJoin('users', eq("users.id", "posts.user_id"));
    expect($join->getBindings())->toBe(['JoinTable' => 'users', 'sql' => "users.id = 'posts.user_id' "]);
});

it('should return the correct inner join SQL', function () {
    $join = new JoinClause();
    $join->innerJoin('users', eq("users.id", "posts.user_id"));
    expect($join->getSql())->toBe('INNER JOIN :JoinTable ON :sql');
});

it('should return the correct inner join bindings', function () {
    $join = new JoinClause();
    $join->innerJoin('users', eq("users.id", "posts.user_id"));
    expect($join->getBindings())->toBe(['JoinTable' => 'users', 'sql' => "users.id = 'posts.user_id' "]);
});

it('should return the correct Full  join SQL', function () {
    $join = new JoinClause();
    $join->fullJoin('users', eq("users.id", "posts.user_id"));
    expect($join->getSql())->toBe('FULL JOIN :JoinTable ON :sql');
});

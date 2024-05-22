<?php

declare(strict_types=1);

use function Yui\ORM\Operators\{eq, exists, gt, between, like, gte, ilike, inArray, isNotNull, isNull, lt, lte, neq, notBetween, notExists, notInArray, notIlike};

it('should return a string with the equal operator', function () {
    $column = 'name';
    $value = 'John Doe';

    $expected = " WHERE $column = '$value' ";
    $actual = eq($column, $value);

    expect($actual)->toBe($expected);
});

it('should return a string with the not equal operator', function () {
    $column = 'name';
    $value = 'John Doe';

    $expected = " WHERE $column != '$value' ";
    $actual = neq($column, $value);

    expect($actual)->toBe($expected);
});

it('should return a string with the greater than operator', function () {
    $column = 'age';
    $value = 18;

    $expected = " WHERE $column > '$value' ";
    $actual = gt($column, $value);

    expect($actual)->toBe($expected);
});

it('should return a string with the greater than or equal operator', function () {
    $column = 'age';
    $value = 18;

    $expected = " WHERE $column >= '$value' ";
    $actual = gte($column, $value);

    expect($actual)->toBe($expected);
});

it('should return a string with the less than operator', function () {
    $column = 'age';
    $value = 18;

    $expected = " WHERE $column < '$value' ";
    $actual = lt($column, $value);

    expect($actual)->toBe($expected);
});

it('should return a string with the less than or equal operator', function () {
    $column = 'age';
    $value = 18;

    $expected = " WHERE $column <= '$value' ";
    $actual = lte($column, $value);

    expect($actual)->toBe($expected);
});

it('should return a string with the between operator', function () {
    $column = 'age';
    $value1 = 18;
    $value2 = 25;

    $expected = " WHERE $column BETWEEN '$value1' AND '$value2' ";
    $actual = between($column, $value1, $value2);

    expect($actual)->toBe($expected);
});

it('should return a string with the not between operator', function () {
    $column = 'age';
    $value1 = 18;
    $value2 = 25;

    $expected = " WHERE $column NOT BETWEEN '$value1' AND '$value2' ";
    $actual = notBetween($column, $value1, $value2);

    expect($actual)->toBe($expected);
});

it('should return a string with the in array operator', function () {
    $column = 'age';
    $values = [18, 25, 30];

    $expected = " WHERE $column IN ('18', '25', '30') ";
    $actual = inArray($column, $values);

    expect($actual)->toBe($expected);
});

it('should return a string with the not in array operator', function () {
    $column = 'age';
    $values = [18, 25, 30];

    $expected = " WHERE $column NOT IN ('18', '25', '30') ";
    $actual = notInArray($column, $values);

    expect($actual)->toBe($expected);
});

it('should return a string with the like operator', function () {
    $column = 'name';
    $value = 'John';

    $expected = " WHERE $column LIKE '%John%' ";
    $actual = like($column, $value);

    expect($actual)->toBe($expected);
});

it('should return a string with the ilike operator', function () {
    $column = 'name';
    $value = 'John';

    $expected = " WHERE $column ILIKE '%John%' ";
    $actual = ilike($column, $value);

    expect($actual)->toBe($expected);
});

it('should return a string with the exists operator', function () {
    $column = 'name';
    $query = "SELECT * FROM users WHERE name = testing";

    $expected = " WHERE EXISTS (SELECT * FROM users WHERE name = testing) ";
    $actual = exists($column, $query);

    expect($actual)->toBe($expected);
});

it('should return a string with the not exists operator', function () {
    $column = 'name';
    $query = "SELECT * FROM users WHERE name = testing";

    $expected = " WHERE NOT EXISTS (SELECT * FROM users WHERE name = testing) ";
    $actual = notExists($column, $query);

    expect($actual)->toBe($expected);
});

it('should return a string with the is null operator', function () {
    $column = 'name';

    $expected = " WHERE $column IS NULL ";
    $actual = isNull($column);

    expect($actual)->toBe($expected);
});

it('should return a string with the is not null operator', function () {
    $column = 'name';

    $expected = " WHERE $column IS NOT NULL ";
    $actual = isNotNull($column);

    expect($actual)->toBe($expected);
});
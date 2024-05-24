<?php

declare(strict_types=1);

use function Yui\ORM\Operators\{eq, exists, gt, between, like, gte, ilike, inArray, isNotNull, isNull, lt, lte, neq, notBetween, notExists, notInArray, notIlike};

it('should return a string with the equal operator', function () {
    $column = 'name';
    $value = 'John Doe';

    $expected = "$column = '$value' ";
    $actual = eq($column, $value);

    expect($actual)->toBe($expected);
});

it('should return without quotes if the value is an integer in the equal operator', function () {
    $column = 'age';
    $value = 18;

    $expected = "$column = $value ";
    $actual = eq($column, $value);

    expect($actual)->toBe($expected);
});

it('should return a string with the not equal operator', function () {
    $column = 'name';
    $value = 'John Doe';

    $expected = "$column != '$value' ";
    $actual = neq($column, $value);

    expect($actual)->toBe($expected);
});

it('should return without quotes if the value is an integer in the not equal operator', function () {
    $column = 'age';
    $value = 18;

    $expected = "$column != $value ";
    $actual = neq($column, $value);

    expect($actual)->toBe($expected);
});

it('should return a string with the greater than operator', function () {
    $column = 'age';
    $value = 18;

    $expected = "$column > $value ";
    $actual = gt($column, $value);

    expect($actual)->toBe($expected);
});

it('should return a string with the greater than or equal operator', function () {
    $column = 'age';
    $value = 18;

    $expected = "$column >= $value ";
    $actual = gte($column, $value);

    expect($actual)->toBe($expected);
});

it('should return a string with the less than operator', function () {
    $column = 'age';
    $value = 18;

    $expected = "$column < $value ";
    $actual = lt($column, $value);

    expect($actual)->toBe($expected);
});

it('should return a string with the less than or equal operator', function () {
    $column = 'age';
    $value = 18;

    $expected = "$column <= $value ";
    $actual = lte($column, $value);

    expect($actual)->toBe($expected);
});

it('should return a string with the between operator', function () {
    $column = 'age';
    $value1 = 18;
    $value2 = 25;

    $expected = "$column BETWEEN $value1 AND $value2 ";
    $actual = between($column, $value1, $value2);

    expect($actual)->toBe($expected);
});

it('should return a string with the not between operator', function () {
    $column = 'age';
    $value1 = 18;
    $value2 = 25;

    $expected = "$column NOT BETWEEN $value1 AND $value2 ";
    $actual = notBetween($column, $value1, $value2);

    expect($actual)->toBe($expected);
});

it('should return a string with the in array operator', function () {
    $column = 'age';
    $values = [18, 25, 30];

    $expected = "$column IN (18, 25, 30) ";
    $actual = inArray($column, $values);

    expect($actual)->toBe($expected);
});

it('should return a string with the not in array operator', function () {
    $column = 'age';
    $values = [18, 25, 30];

    $expected = "$column NOT IN (18, 25, 30) ";
    $actual = notInArray($column, $values);

    expect($actual)->toBe($expected);
});

it('should return a string with the like operator', function () {
    $column = 'name';
    $value = '%John%';

    $expected = "$column LIKE '%John%' ";
    $actual = like($column, $value);

    expect($actual)->toBe($expected);
});

it('should return a string with the ilike operator', function () {
    $_ENV['DB_CONNECTION'] = 'pgsql';
    $column = 'name';
    $value = '%John%';

    $expected = "$column ILIKE '%John%' ";
    $actual = ilike($column, $value);

    expect($actual)->toBe($expected);
    $_ENV['DB_CONNECTION'] = '';
});

it('should return a string with the not ilike operator', function () {
    $column = 'name';
    $value = '%John%';

    $expected = "$column NOT ILIKE '%John%' ";
    $actual = notIlike($column, $value);

    expect($actual)->toBe($expected);
});

it('should return a string with the exists operator', function () {
    $query = "SELECT * FROM users  name = testing";

    $expected = "EXISTS (SELECT * FROM users  name = testing) ";
    $actual = exists($query);

    expect($actual)->toBe($expected);
});

it('should return a string with the not exists operator', function () {
    $column = 'name';
    $query = "SELECT * FROM users  name = testing";

    $expected = "NOT EXISTS (SELECT * FROM users  name = testing) ";
    $actual = notExists($query);

    expect($actual)->toBe($expected);
});

it('should return a string with the is null operator', function () {
    $column = 'name';

    $expected = "$column IS NULL ";
    $actual = isNull($column);

    expect($actual)->toBe($expected);
});

it('should return a string with the is not null operator', function () {
    $column = 'name';

    $expected = "$column IS NOT NULL ";
    $actual = isNotNull($column);

    expect($actual)->toBe($expected);
});

<?php

declare(strict_types=1);

use Yui\ORM\Builders\Select\SelectBuilder;
use function Yui\ORM\db;
use function Yui\ORM\Operators\eq;
use function Yui\ORM\Operators\neq;

it('should return a query containing the columns passed in the select()', function () {
    $builder = new SelectBuilder('name', 'email');
    $query = $builder->getSqlWithBindings();
    $this->assertEquals('SELECT name, email FROM ', $query);
});

it('should return a query containing all columns when no columns are passed in the select()', function () {
    $builder = new SelectBuilder();
    $query = $builder->getSqlWithBindings();
    $this->assertEquals('SELECT * FROM ', $query);
});

it('should return a query containing the columns passed in the select() and reset the columns', function () {
    $builder = new SelectBuilder('name', 'email');
    $query = $builder->getSqlWithBindings();
    $this->assertEquals('SELECT name, email FROM ', $query);

    $otherBuilder = new SelectBuilder();
    $query = $otherBuilder->getSqlWithBindings();
    $this->assertEquals('SELECT * FROM ', $query);
});

it('should return a query containing the table name', function () {
    $builder = new SelectBuilder('name', 'email');
    $query = $builder->from('users')->getSqlWithBindings();

    $this->assertEquals('SELECT name, email FROM users', $query);
});

it('should return a query containing the where condition', function () {
    $id = 1;

    $builder = new SelectBuilder('name', 'email');
    $query = $builder->from('users')->where("id = $id")->getSqlWithBindings();

    $this->assertEquals('SELECT name, email FROM users WHERE id = 1', $query);
});

it('should return a query containing the where condition as a callable', function () {
    $id = 1;
    $id2 = 2;
    $id3 = 3;

    $builder1 = new SelectBuilder('name', 'email');
    $query = $builder1->from('users')->where(neq("id", $id))->getSqlWithBindings();

    $builder2 = new SelectBuilder('name', 'email');
    $query2 = $builder2->from('users')->where(fn () => "id = $id2")->getSqlWithBindings();

    $builder3 = new SelectBuilder('name', 'email');
    $query3 = $builder3->from('users')->where(eq('id', $id3))->getSqlWithBindings();

    $this->assertEquals('SELECT name, email FROM users WHERE id != 1 ', $query);
    $this->assertEquals('SELECT name, email FROM users WHERE id = 2', $query2);
    $this->assertEquals('SELECT name, email FROM users WHERE id = 3 ', $query3);
});

it('should return a query containing the and where condition', function () {
    $id = 1;

    $builder = new SelectBuilder('name', 'email');
    $query = $builder->from('users')->where("id = $id")->andWhere("name = 'John'")->getSqlWithBindings();

    $this->assertEquals("SELECT name, email FROM users WHERE id = 1 AND name = 'John'", $query);
});

it('should removes the words Where, Or, And when passed redundantly', function () {
    $id = 1001;
    $name = 'John';

    $builder = new SelectBuilder('name', 'email');
    echo "AQUI: \n";
    $query = $builder->from('users')->where("WHERE id = $id")->andWhere("AND name = $name")->getSqlWithBindings();

    $builder2 = new SelectBuilder('name', 'email');
    echo "AQUI 2: \n";
    $query2 = $builder2->from('users')->where("WHERE id = $id")->andWhere(eq('name', $name))->getSqlWithBindings();

    $this->assertEquals("SELECT name, email FROM users WHERE id = 1001 AND name = 'John'", $query);
    $this->assertEquals("SELECT name, email FROM users WHERE id = 2 AND name = 'Doe' ", $query2);
});

it('should throw an exception when calling andWhere() before where()', function () {
    $this->expectException(Exception::class);
    $this->expectExceptionMessage('You must call where() before calling andWhere()');

    $builder = new SelectBuilder('name', 'email');
    $builder->from('users')->andWhere("WHERE name = 'John'")->getSqlWithBindings();
});

it('should return a query containing the or where condition', function () {
    $id = 1;
    $name = 'John';
    $query = db()
        ->select('name', 'email')
        ->from('users')
        ->where("WHERE id = $id")
        ->orWhere("WHERE name = $name")
        ->getSqlWithBindings();

    $this->assertEquals('SELECT name, email FROM users WHERE id = 1 OR name = John', $query);
});

it('should throw an exception when calling orWhere() before where()', function () {
    $this->expectException(Exception::class);
    $this->expectExceptionMessage('You must call where() before calling andWhere() or orWhere()');

    db()
        ->select('name', 'email')
        ->from('users')
        ->orWhere("WHERE name = 'John'")
        ->getSqlWithBindings();
});

it('should return a query containing the distinct clause', function () {
    $query = db()
        ->select('name', 'email')
        ->from('users')
        ->distinct()
        ->getSqlWithBindings();

    $this->assertEquals('SELECT DISTINCT name, email FROM users', $query);
});

it('should throw an exception when calling distinct() more than once', function () {
    $this->expectException(Exception::class);
    $this->expectExceptionMessage('DISTINCT can only be called once');

    db()
        ->select('name', 'email')
        ->from('users')
        ->distinct()
        ->distinct()
        ->getSqlWithBindings();
});

it('should return a query containing the distinct on clause', function () {
    $_ENV['DB_CONNECTION'] = 'pgsql';
    $query = db()
        ->select('name', 'email')
        ->from('users')
        ->distinctOn('name', 'email')
        ->getSqlWithBindings();

    $this->assertEquals('SELECT DISTINCT ON (name, email) name, email FROM users', $query);
});

it('should throw an exception when calling distinctOn() more than once', function () {
    $_ENV['DB_CONNECTION'] = 'pgsql';
    $this->expectException(Exception::class);
    $this->expectExceptionMessage('DISTINCT can only be called once');

    db()
        ->select('name', 'email')
        ->from('users')
        ->distinctOn('name', 'email')
        ->distinctOn('name', 'email')
        ->getSqlWithBindings();
});

it('should throw an exception when calling distinctOn() in a non Postgres environment', function () {
    $_ENV['DB_CONNECTION'] = 'mysql';
    $this->expectException(Exception::class);
    $this->expectExceptionMessage('DISTINCT ON is only supported in Postgres');

    db()
        ->select('name', 'email')
        ->from('users')
        ->distinctOn('name', 'email')
        ->getSqlWithBindings();
});

it('should return a query containing the limit clause', function () {
    $query = db()
        ->select('name', 'email')
        ->from('users')
        ->limit(10)
        ->getSqlWithBindings();

    $this->assertEquals('SELECT name, email FROM users LIMIT 10', $query);
});

it('should return a query containing the offset clause', function () {
    $query = db()
        ->select('name', 'email')
        ->from('users')
        ->offset(10)
        ->getSqlWithBindings();

    $this->assertEquals('SELECT name, email FROM users OFFSET 10', $query);
});

it('should return a query containing the order by clause', function () {
    $query = db()
        ->select('name', 'email')
        ->from('users')
        ->orderBy('name')
        ->getSqlWithBindings();

    $this->assertEquals('SELECT name, email FROM users ORDER BY name ASC', $query);
});

it('should return a query containing the order by clause with a direction', function () {
    $query = db()
        ->select('name', 'email')
        ->from('users')
        ->orderBy('name', 'DESC')
        ->getSqlWithBindings();

    $this->assertEquals('SELECT name, email FROM users ORDER BY name DESC', $query);
});

it('should return a query containing the group by clause', function () {
    $query = db()
        ->select('name', 'email')
        ->from('users')
        ->groupBy('name')
        ->getSqlWithBindings();

    $this->assertEquals('SELECT name, email FROM users GROUP BY name', $query);
});

it('should return a query containing the having clause', function () {
    $query = db()
        ->select('name', 'email')
        ->from('users')
        ->groupBy('name')
        ->having('COUNT(name) > 1')
        ->getSqlWithBindings();

    $this->assertEquals('SELECT name, email FROM users GROUP BY name HAVING COUNT(name) > 1', $query);
});

it('should throw an exception when calling having() before groupBy()', function () {
    $this->expectException(Exception::class);
    $this->expectExceptionMessage('You must call groupBy() before calling having()');

    db()
        ->select('name', 'email')
        ->from('users')
        ->having('COUNT(name) > 1')
        ->getSqlWithBindings();
});

it('shoudld return a query containing the alias clause', function () {
    $query = db()
        ->select('name')
        ->from('users')
        ->columnAs('name', 'user_name')
        ->getSqlWithBindings();

    $this->assertEquals('SELECT name AS user_name FROM users', $query);
});

it('should return a query containing the alias clause for multiple columns', function () {
    $query = db()
        ->select('name', 'email')
        ->from('users')
        ->columnAs('name', 'user_name')
        ->columnAs('email', 'user_email')
        ->getSqlWithBindings();

    $this->assertEquals('SELECT name AS user_name, email AS user_email FROM users', $query);
});

it('should return a query containing the alias clause for multiple columns and reset the aliases', function () {
    $query = db()
        ->select('name', 'email')
        ->from('users')
        ->columnAs('name', 'user_name')
        ->columnAs('email', 'user_email')
        ->getSqlWithBindings();

    $this->assertEquals('SELECT name AS user_name, email AS user_email FROM users', $query);

    $query = db()
        ->select('name', 'email')
        ->from('users')
        ->getSqlWithBindings();

    $this->assertEquals('SELECT name, email FROM users', $query);
});

it('should return a query containing the left join clause', function () {
    $query = db()
        ->select('name', 'email')
        ->from('users')
        ->leftJoin('posts', 'users.id = posts.user_id')
        ->getSqlWithBindings();

    $this->assertEquals('SELECT name, email FROM users LEFT JOIN posts ON users.id = posts.user_id', $query);
});

it('should return a query containing the right join clause', function () {
    $query = db()
        ->select('name', 'email')
        ->from('users')
        ->rightJoin('posts', 'users.id = posts.user_id')
        ->getSqlWithBindings();

    $this->assertEquals('SELECT name, email FROM users RIGHT JOIN posts ON users.id = posts.user_id', $query);
});

it('should return a query containing the inner join clause', function () {
    $query = db()
        ->select('name', 'email')
        ->from('users')
        ->innerJoin('posts', 'users.id = posts.user_id')
        ->getSqlWithBindings();

    $this->assertEquals('SELECT name, email FROM users INNER JOIN posts ON users.id = posts.user_id', $query);
});

it('should return a query containing the full join clause', function () {
    $query = db()
        ->select('name', 'email')
        ->from('users')
        ->fullJoin('posts', 'users.id = posts.user_id')
        ->getSqlWithBindings();

    $this->assertEquals('SELECT name, email FROM users FULL JOIN posts ON users.id = posts.user_id', $query);
});

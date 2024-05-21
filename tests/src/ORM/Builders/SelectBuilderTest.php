<?php

declare(strict_types=1);

use function Yui\ORM\db;
use function Yui\ORM\eq;
use function Yui\ORM\sql;

it('should return a query containing the columns passed in the select()', function(){
	$query = db()->select('name', 'email')->getSql();
	$this->assertMatchesRegularExpression('/SELECT name, email/', $query);
});

it('should return a query containing all columns when no columns are passed in the select()', function(){
	$query = db()->select()->getSql();
	$this->assertMatchesRegularExpression('/SELECT \*/', $query);
});

it('should return a query containing the columns passed in the select() and reset the columns', function(){
	$query = db()->select('name', 'email')->getSql();
	$this->assertMatchesRegularExpression('/SELECT name, email/', $query);

	$query = db()->select()->getSql();
	$this->assertMatchesRegularExpression('/SELECT \*/', $query);
});

it('should return a query containing the table name', function(){

	$query = db()
			->select('name', 'email')
			->from('users')
			->getSql();
	$this->assertMatchesRegularExpression('/FROM users/', $query);
});

it('should return a query containing the where condition', function(){
	$id = 1;
	$query = db()
			->select('name', 'email')
			->from('users')
			->where("WHERE id = {$id}")
			->getSql();
		
	$this->assertMatchesRegularExpression('/WHERE id = 1/', $query);
});

it('should return a query containing the where condition as a callable', function(){
	$id = 1;
	$query = db()
			->select('name', 'email')
			->from('users')
			->where(sql("WHERE id = {$id}"))
			->getSql();
		
	$id2 = 2;
	$query2 = db()
			->select('name', 'email')
			->from('users')
			->where(fn() => "WHERE id = {$id2}")
			->getSql();

	$id3 = 3;
	$query3 = db()
			->select('name', 'email')
			->from('users')
			->where(eq('id', $id3))
			->getSql();

	$this->assertMatchesRegularExpression('/WHERE id = 1/', $query);
	$this->assertMatchesRegularExpression('/WHERE id = 2/', $query2);
	$this->assertMatchesRegularExpression("/WHERE id = '3'/", $query3);
});

it('should return a query containing the and where condition', function(){
	$id = 1;
	$name = 'John';
	$query = db()
			->select('name', 'email')
			->from('users')
			->where("WHERE id = {$id}")
			->andWhere("WHERE name = {$name}")
			->getSql();
		
	$this->assertMatchesRegularExpression('/AND WHERE name/', $query);
});

it('should throw an exception when calling andWhere() before where()', function(){
	$this->expectException(Exception::class);
	$this->expectExceptionMessage('You must call where() before calling andWhere()');
	
	db()
		->select('name', 'email')
		->from('users')
		->andWhere("WHERE name = 'John'")
		->getSql();
});

it('should return a query containing the or where condition', function(){
	$id = 1;
	$name = 'John';
	$query = db()
			->select('name', 'email')
			->from('users')
			->where("WHERE id = {$id}")
			->orWhere("WHERE name = {$name}")
			->getSql();
		
	$this->assertMatchesRegularExpression('/OR WHERE name/', $query);
});

it('should throw an exception when calling orWhere() before where()', function(){
	$this->expectException(Exception::class);
	$this->expectExceptionMessage('You must call where() before calling orWhere()');
	
	db()
		->select('name', 'email')
		->from('users')
		->orWhere("WHERE name = 'John'")
		->getSql();
});

it('should return a query containing the distinc clause', function(){
	$query = db()
			->select('name', 'email')
			->from('users')
			->distinct()
			->getSql();
		
	$this->assertMatchesRegularExpression('/SELECT DISTINCT/', $query);
});

it('should throw an exception when calling distinct() more than once', function(){
	$this->expectException(Exception::class);
	$this->expectExceptionMessage('DISTINCT can only be called once');
	
	db()
		->select('name', 'email')
		->from('users')
		->distinct()
		->distinct()
		->getSql();
});

it('should return a query containing the distinct on clause', function(){
	$_ENV['DB_CONNECTION'] = 'pgsql';
	$query = db()
			->select('name', 'email')
			->from('users')
			->distinctOn('name', 'email')
			->getSql();
		
	$this->assertMatchesRegularExpression('/SELECT DISTINCT ON \(name, email\)/', $query);
});

it('should throw an exception when calling distinctOn() more than once', function(){
	$_ENV['DB_CONNECTION'] = 'pgsql';
	$this->expectException(Exception::class);
	$this->expectExceptionMessage('DISTINCT can only be called once');
	
	db()
		->select('name', 'email')
		->from('users')
		->distinctOn('name', 'email')
		->distinctOn('name', 'email')
		->getSql();
});

it('should throw an exception when calling distinctOn() in a non Postgres environment', function(){
	$_ENV['DB_CONNECTION'] = 'mysql';
	$this->expectException(Exception::class);
	$this->expectExceptionMessage('DISTINCT ON is only supported in Postgres');
	
	db()
		->select('name', 'email')
		->from('users')
		->distinctOn('name', 'email')
		->getSql();
});

it('should return a query containing the limit clause', function(){
	$query = db()
			->select('name', 'email')
			->from('users')
			->limit(10)
			->getSql();
		
	$this->assertMatchesRegularExpression('/LIMIT 10/', $query);
});

it('should return a query containing the offset clause', function(){
	$query = db()
			->select('name', 'email')
			->from('users')
			->offset(10)
			->getSql();
		
	$this->assertMatchesRegularExpression('/OFFSET 10/', $query);
});

it('should return a query containing the order by clause', function(){
	$query = db()
			->select('name', 'email')
			->from('users')
			->orderBy('name')
			->getSql();
		
	$this->assertMatchesRegularExpression('/ORDER BY name ASC/', $query);
});

it('should return a query containing the order by clause with a direction', function(){
	$query = db()
			->select('name', 'email')
			->from('users')
			->orderBy('name', 'DESC')
			->getSql();
		
	$this->assertMatchesRegularExpression('/ORDER BY name DESC/', $query);
});
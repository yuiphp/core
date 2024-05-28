<?php

use Yui\ORM\Builders\Delete\DeleteBuilder;
use Yui\ORM\Builders\Insert\InsertBuilder;
use Yui\ORM\Builders\Select\SelectBuilder;
use Yui\ORM\Builders\Update\UpdateBuilder;
use Yui\ORM\Builders\Upsert\UpsertBuilder;
use Yui\ORM\QueryBuilder;
use function Yui\ORM\db;

beforeEach(function () {
    $dbMock = $this->createMock(\Yui\Database\DB::class);
    $containerMock = $this->createMock(\DI\Container::class);
    $containerMock->method('get')->willReturn($dbMock);
});

afterEach(function () {
    Mockery::close();
});

it('should return a query builder instance', function () {
    $this->assertInstanceOf(QueryBuilder::class, db());
});

it('should return a select query builder instance when calling select()', function () {
    $this->assertInstanceOf(SelectBuilder::class, db()->select('table'));
});

it('should return a insert query builder instance when calling insert()', function () {
    $this->assertInstanceOf(InsertBuilder::class, db()->insert());
});

it('should return a update query builder instance when calling update()', function () {
    $this->assertInstanceOf(UpdateBuilder::class, db()->update());
});

it('should return a delete query builder instance when calling delete()', function () {
    $this->assertInstanceOf(DeleteBuilder::class, db()->delete());
});

it('should return a upsert query builder instance when calling delete()', function () {
    $this->assertInstanceOf(UpsertBuilder::class, db()->delete());
});
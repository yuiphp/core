<?php

declare(strict_types=1);

namespace Yui\ORM;

function eq(string $column, mixed $value): string
{
	return " WHERE $column = '$value' ";
}

function neq(string $column, mixed $value): string
{
	return " WHERE $column != '$value' ";
}

function gt(string $column, mixed $value): string
{
	return " WHERE $column > '$value' ";
}

function gte(string $column, mixed $value): string
{
	return " WHERE $column >= '$value' ";
}

function lt(string $column, mixed $value): string
{
	return " WHERE $column < '$value' ";
}

function lte(string $column, mixed $value): string
{
	return " WHERE $column <= '$value' ";
}
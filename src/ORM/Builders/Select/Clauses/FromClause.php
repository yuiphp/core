<?php

declare(strict_types=1);

namespace Yui\ORM\Builders\Select\Clauses;

class FromClause
{
	protected string $table;

	public function __construct(protected $builder, string $table)
	{
		$this->table = $table;		
	}

	public function get()
	{
		return $this->builder->get() . " FROM {$this->table}";
	}
}
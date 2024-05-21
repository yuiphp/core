<?php

declare(strict_types=1);

namespace Yui\ORM\Builders\Insert;

class InsertBuilder
{
	protected string $table;
	protected array $columns = [];
	protected array $values = [];

	public function __construct(string $table)
	{
		$this->table = $table;
	}
}
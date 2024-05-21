<?php

declare(strict_types=1);

namespace Yui\ORM;

use Yui\ORM\QueryBuilder;

function db(): QueryBuilder
{
	return new QueryBuilder();
}
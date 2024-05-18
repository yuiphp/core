<?php

declare(strict_types=1);

namespace Yui\Contracts\Database\Driver;

use PDO;

interface DriverContract
{
    public function connect(): PDO;
}

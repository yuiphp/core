<?php

declare(strict_types=1);

namespace Yui\Contracts\Database\Driver;

use PDO;

/**
 * Interface DriverContract
 *
 * @author andrefelipe18
 * @package Yui\Contracts\Database\Driver
 */
interface DriverContract
{
    /**
     * Connect to the database.
     *
     * @return PDO
     */
    public function connect(): PDO;
}

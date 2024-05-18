<?php

declare(strict_types=1);

namespace Yui\Contracts\Bootstrap;

use Yui\Contracts\Application;

interface Bootstrap
{
    public function bootstrap(Application $app): void;
}

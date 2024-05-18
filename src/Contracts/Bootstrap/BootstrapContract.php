<?php

declare(strict_types=1);

namespace Yui\Contracts\Bootstrap;

use Yui\Contracts\Application;

interface BootstrapContract
{
    public function bootstrap(Application $app): void;
}

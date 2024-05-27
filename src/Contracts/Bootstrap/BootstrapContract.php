<?php

declare(strict_types=1);

namespace Yui\Contracts\Bootstrap;

use Yui\Application;

/**
 * Interface BootstrapContract
 *
 * @author andrefelipe18
 * @package Yui\Contracts\Bootstrap
 */
interface BootstrapContract
{
    /**
     * Bootstrap the service
     *
     * @param Application $app
     * @return void
     */
    public function bootstrap(Application $app): void;
}

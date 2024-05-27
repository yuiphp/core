<?php

namespace Yui\Container;

use DI\ContainerBuilder;
use DI\DependencyException;
use DI\NotFoundException;
use Exception;

/**
 * Class Container
 *
 * @package Yui\Container
 */
class Container
{
    public function build(): \DI\Container
    {
        $builder = new ContainerBuilder();
        $builder->useAutowiring(true);
        $builder->useAttributes(true);

        $this->setDefinitions($builder);

        try {
            return $builder->build();
        } catch (Exception $e) {
            throw new \RuntimeException('Error building container', 0, $e);
        }
    }

    private function setDefinitions(ContainerBuilder $builder): void
    {
        $definitions = require __DIR__ . '/Definitions.php';

        foreach($definitions as $definition)
        {
            $builder->addDefinitions(require $definition);
        }
    }
}

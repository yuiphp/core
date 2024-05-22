<?php

declare(strict_types=1);

namespace Yui\Contracts\ORM\Clauses;


interface ClauseContract
{
    public function set(array $data): void;

    public function getSql(): string;
}
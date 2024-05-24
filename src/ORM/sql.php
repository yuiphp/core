<?php

declare(strict_types=1);

namespace Yui\ORM;

function sql(string $template, array $params = []): string
{
    $sql = $template;

    // Replace placeholders with actual values
    foreach ($params as $placeholder => $value) {
        $sql = str_replace(":$placeholder", "'" . addslashes($value) . "'", $sql);
    }

    return $sql;
}

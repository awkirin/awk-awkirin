<?php

use Symfony\Component\Filesystem\Path;

function path(string $path): string
{
    if (str_starts_with($path, '~')) {
        $home = $_SERVER['HOME'] ?? $_SERVER['USERPROFILE'] ?? throw new RuntimeException('Cannot resolve home directory');
        $path = $home.substr($path, 1);
    }

    return Path::canonicalize($path);

}

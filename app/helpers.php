<?php

function path(string $path): string
{
    if (str_starts_with($path, '~/')) {
        $home = getenv(PHP_OS_FAMILY === 'Windows' ? 'USERPROFILE' : 'HOME');
        $path = $home . DIRECTORY_SEPARATOR . substr($path, 2);
    }
    $path = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);

    return $path;
}


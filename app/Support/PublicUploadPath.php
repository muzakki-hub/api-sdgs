<?php

namespace App\Support;

class PublicUploadPath
{
    public static function ensure(string $relativePath): string
    {
        $path = public_path($relativePath);

        if (! is_dir($path)) {
            mkdir($path, 0755, true);
        }

        return $path;
    }
}

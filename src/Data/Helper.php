<?php

namespace App\Data;

class Helper
{
    public static function absPath( string $path ): string
    {
        return realpath( ROOT_PATH . ltrim( $path, '/\\' ) );
    }
}
<?php

namespace App\Helpers;

class SecurityHelper
{
    /**
     * Escape special characters for SQL LIKE operator to prevent wildcard injection.
     */
    public static function escapeLike(string $value): string
    {
        return str_replace(['\\', '%', '_'], ['\\\\', '\%', '\_'], $value);
    }
}
